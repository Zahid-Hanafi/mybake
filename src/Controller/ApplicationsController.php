<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class ApplicationsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        if ($this->components()->has('Security')) {
            $this->Security->setConfig('unlockedActions', [
                'add', 
                'edit', 
                'delete', 
                'addSlot', 
                'deleteSlot',
                'acceptApplication',
                'rejectApplication'
            ]);
        }
    }

    /**
     * Check if current user is admin
     */
    private function isAdmin(): bool
    {
        $identity = $this->Authentication->getIdentity();
        return $identity && $identity->get('role') === 'admin';
    }

    /**
     * Join Us page - Student view for applying to PMH
     */
    public function joinus()
    {
        $userId = $this->Authentication->getIdentity()->id;
        
        // Fetch student's applications with interview slot details
        $myApplications = $this->Applications->find()
            ->where(['Applications.user_id' => $userId])
            ->contain(['InterviewSlots'])
            ->order(['Applications.created_at' => 'DESC'])
            ->all();

        // Get available interview slots for the form
        $interviewSlotsTable = $this->fetchTable('InterviewSlots');
        $availableSlots = $interviewSlotsTable->find('available')->all();
        
        // Format slots for dropdown
        $slotOptions = [];
        foreach ($availableSlots as $slot) {
            $dateFormatted = $slot->interview_date->format('l, d F Y');
            $slotOptions[$slot->id] = $dateFormatted . ' (' . $slot->slot_time . ')';
        }

        // Get user data for auto-fill
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->get($userId);

        $this->set(compact('myApplications', 'slotOptions', 'user'));
    }

    /**
     * Add new application
     */
    public function add()
    {
        $userId = $this->Authentication->getIdentity()->id;
        
        // Check if user already has a pending application
        $existingPending = $this->Applications->find()
            ->where(['user_id' => $userId, 'status' => 'pending'])
            ->first();
        
        if ($existingPending) {
            $this->Flash->error(__('You already have a pending application. Please wait for it to be processed.'));
            return $this->redirect(['action' => 'joinus']);
        }

        // Get available slots
        $interviewSlotsTable = $this->fetchTable('InterviewSlots');
        $availableSlots = $interviewSlotsTable->find('available')->all();
        
        $slotOptions = [];
        foreach ($availableSlots as $slot) {
            $dateFormatted = $slot->interview_date->format('l, d F Y');
            $slotOptions[$slot->id] = $dateFormatted . ' (' . $slot->slot_time . ')';
        }

        // Get user data
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->get($userId);

        $application = $this->Applications->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $application = $this->Applications->patchEntity($application, $this->request->getData());
            $application->user_id = $userId;
            $application->status = 'pending';
            
            // Mark the interview slot as booked
            $slotId = $this->request->getData('interview_slot_id');
            
            if ($this->Applications->save($application)) {
                // Mark slot as booked
                $slot = $interviewSlotsTable->get($slotId);
                $slot->is_booked = true;
                $interviewSlotsTable->save($slot);
                
                $this->Flash->success(__('Your application has been submitted successfully!'));
                return $this->redirect(['action' => 'joinus']);
            }
            $this->Flash->error(__('Failed to submit application. Please check the form and try again.'));
        }

        $this->set(compact('application', 'slotOptions', 'user'));
    }

    /**
     * Edit application (only pending applications)
     */
    public function edit($id = null)
    {
        $userId = $this->Authentication->getIdentity()->id;
        
        $application = $this->Applications->get($id, [
            'contain' => ['InterviewSlots']
        ]);

        // Ensure user owns this application and it's still pending
        if ($application->user_id !== $userId) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'joinus']);
        }

        if ($application->status !== 'pending') {
            $this->Flash->error(__('You can only edit pending applications.'));
            return $this->redirect(['action' => 'joinus']);
        }

        // Get available slots (include current slot)
        $interviewSlotsTable = $this->fetchTable('InterviewSlots');
        $availableSlots = $interviewSlotsTable->find()
            ->where([
                'OR' => [
                    'InterviewSlots.is_booked' => false,
                    'InterviewSlots.id' => $application->interview_slot_id
                ],
                'InterviewSlots.interview_date >=' => date('Y-m-d')
            ])
            ->order(['InterviewSlots.interview_date' => 'ASC'])
            ->all();
        
        $slotOptions = [];
        foreach ($availableSlots as $slot) {
            $dateFormatted = $slot->interview_date->format('l, d F Y');
            $label = $dateFormatted . ' (' . $slot->slot_time . ')';
            if ($slot->id === $application->interview_slot_id) {
                $label .= ' (Current)';
            }
            $slotOptions[$slot->id] = $label;
        }

        // Get user data
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->get($userId);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $oldSlotId = $application->interview_slot_id;
            $newSlotId = (int)$this->request->getData('interview_slot_id');
            
            $application = $this->Applications->patchEntity($application, $this->request->getData());
            
            if ($this->Applications->save($application)) {
                // Handle slot booking changes
                if ($oldSlotId !== $newSlotId) {
                    // Free old slot
                    $oldSlot = $interviewSlotsTable->get($oldSlotId);
                    $oldSlot->is_booked = false;
                    $interviewSlotsTable->save($oldSlot);
                    
                    // Book new slot
                    $newSlot = $interviewSlotsTable->get($newSlotId);
                    $newSlot->is_booked = true;
                    $interviewSlotsTable->save($newSlot);
                }
                
                $this->Flash->success(__('Application updated successfully!'));
                return $this->redirect(['action' => 'joinus']);
            }
            $this->Flash->error(__('Failed to update application. Please try again.'));
        }

        $this->set(compact('application', 'slotOptions', 'user'));
    }

    /**
     * View application details
     */
    public function view($id = null)
    {
        $userId = $this->Authentication->getIdentity()->id;
        $isAdmin = $this->isAdmin();
        
        $application = $this->Applications->get($id, [
            'contain' => ['Users', 'InterviewSlots']
        ]);

        // Check access: admin can view all, student can only view their own
        if (!$isAdmin && $application->user_id !== $userId) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'joinus']);
        }

        $this->set(compact('application', 'isAdmin'));
    }

    /**
     * Delete application (only pending)
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $userId = $this->Authentication->getIdentity()->id;
        $application = $this->Applications->get($id);

        // Ensure user owns this application and it's pending
        if ($application->user_id !== $userId) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'joinus']);
        }

        if ($application->status !== 'pending') {
            $this->Flash->error(__('You can only withdraw pending applications.'));
            return $this->redirect(['action' => 'joinus']);
        }

        // Free the interview slot
        if ($application->interview_slot_id) {
            $interviewSlotsTable = $this->fetchTable('InterviewSlots');
            $slot = $interviewSlotsTable->get($application->interview_slot_id);
            $slot->is_booked = false;
            $interviewSlotsTable->save($slot);
        }

        if ($this->Applications->delete($application)) {
            $this->Flash->success(__('Application withdrawn successfully.'));
        } else {
            $this->Flash->error(__('Failed to withdraw application.'));
        }

        return $this->redirect(['action' => 'joinus']);
    }

    /**
     * Admin: View all applications with search/filter
     */
    public function adminIndex()
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(__('Access denied. Admin privileges required.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'dashboard']);
        }

        // Get filter parameters
        $search = $this->request->getQuery('search');
        $searchMatric = $this->request->getQuery('search_matric');
        $filterGender = $this->request->getQuery('gender');
        $sortBy = $this->request->getQuery('sort');

        $query = $this->Applications->find()
            ->contain(['Users', 'InterviewSlots']);

        // Search by name (case-insensitive)
        if (!empty($search)) {
            $query->where(['Users.full_name LIKE' => '%' . $search . '%']);
        }

        // Search by exact matric number
        if (!empty($searchMatric)) {
            $query->where(['Users.matric_no' => $searchMatric]);
        }

        // Filter by gender
        if (!empty($filterGender)) {
            $query->where(['Applications.gender' => $filterGender]);
        }

        // Sort
        switch ($sortBy) {
            case 'cgpa':
                $query->order(['Applications.cgpa' => 'DESC']);
                break;
            case 'semester':
                $query->order(['Applications.semester' => 'ASC']);
                break;
            default:
                $query->order(['Applications.created_at' => 'DESC']);
        }

        $applications = $query->all();

        // Stats
        $totalApplications = $this->Applications->find()->count();
        $totalAccepted = $this->Applications->find()->where(['status' => 'accepted'])->count();
        $totalRejected = $this->Applications->find()->where(['status' => 'rejected'])->count();
        $totalPending = $this->Applications->find()->where(['status' => 'pending'])->count();

        // Get interview slots for management
        $interviewSlotsTable = $this->fetchTable('InterviewSlots');
        $interviewSlots = $interviewSlotsTable->find()
            ->order(['interview_date' => 'ASC', 'slot_time' => 'ASC'])
            ->all();

        // Rejection reasons
        $rejectionReasons = [
            'fake_info' => 'The information provided was found to be false or manipulated',
            'not_eligible' => 'The applicant does not meet PMH eligibility criteria',
            'no_show' => 'Interview session was not attended without valid reason'
        ];

        $this->set(compact(
            'applications', 
            'totalApplications', 
            'totalAccepted', 
            'totalRejected',
            'totalPending',
            'interviewSlots',
            'rejectionReasons',
            'search',
            'searchMatric',
            'filterGender',
            'sortBy'
        ));
    }

    /**
     * Admin: Accept application
     */
    public function acceptApplication($id = null)
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'adminIndex']);
        }

        $this->request->allowMethod(['post']);
        
        // Use direct update to ensure status is saved
        $result = $this->Applications->updateAll(
            ['status' => 'accepted'],
            ['id' => $id]
        );

        if ($result > 0) {
            $this->Flash->success(__('Application has been ACCEPTED successfully!'));
        } else {
            $this->Flash->error(__('Failed to accept application. Application not found.'));
        }

        return $this->redirect(['action' => 'adminIndex']);
    }

    /**
     * Admin: Reject application
     */
    public function rejectApplication($id = null)
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'adminIndex']);
        }

        $this->request->allowMethod(['post']);
        
        $rejectionReason = $this->request->getData('rejection_reason');

        if (empty($rejectionReason)) {
            $this->Flash->error(__('Please select a rejection reason.'));
            return $this->redirect(['action' => 'adminIndex']);
        }

        // Use direct update to ensure status is saved
        $result = $this->Applications->updateAll(
            [
                'status' => 'rejected',
                'rejection_reason' => $rejectionReason
            ],
            ['id' => $id]
        );

        if ($result > 0) {
            $this->Flash->success(__('Application has been REJECTED.'));
        } else {
            $this->Flash->error(__('Failed to reject application. Application not found.'));
        }

        return $this->redirect(['action' => 'adminIndex']);
    }

    /**
     * Admin: Add new interview slot
     */
    public function addSlot()
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'adminIndex']);
        }

        $this->request->allowMethod(['post']);
        
        $interviewSlotsTable = $this->fetchTable('InterviewSlots');
        
        // Get form data
        $interviewDate = $this->request->getData('interview_date');
        $slotTime = $this->request->getData('slot_time');
        
        // Validate: Check if date is in the past
        $today = date('Y-m-d');
        if ($interviewDate < $today) {
            $this->Flash->error(__('Cannot add slots for past dates. Please select a date from today onwards.'));
            return $this->redirect(['action' => 'adminIndex']);
        }
        
        // Check for duplicate slot (same date and time)
        $existingSlot = $interviewSlotsTable->find()
            ->where([
                'interview_date' => $interviewDate,
                'slot_time' => $slotTime
            ])
            ->first();
        
        if ($existingSlot) {
            $this->Flash->error(__('This slot already exists! Please choose a different date or time.'));
            return $this->redirect(['action' => 'adminIndex']);
        }
        
        $slot = $interviewSlotsTable->newEmptyEntity();
        $slot = $interviewSlotsTable->patchEntity($slot, $this->request->getData());

        if ($interviewSlotsTable->save($slot)) {
            $this->Flash->success(__('Interview slot added successfully!'));
        } else {
            $errors = $slot->getErrors();
            $errorMsg = 'Failed to add slot.';
            if (!empty($errors)) {
                $firstError = array_values($errors)[0];
                $errorMsg .= ' ' . array_values($firstError)[0];
            }
            $this->Flash->error(__($errorMsg));
        }

        return $this->redirect(['action' => 'adminIndex']);
    }

    /**
     * Admin: Delete interview slot
     */
    public function deleteSlot($id = null)
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'adminIndex']);
        }

        $this->request->allowMethod(['post', 'delete']);
        
        $interviewSlotsTable = $this->fetchTable('InterviewSlots');
        $slot = $interviewSlotsTable->get($id);

        if ($slot->is_booked) {
            $this->Flash->error(__('Cannot delete a booked slot. Please handle the application first.'));
            return $this->redirect(['action' => 'adminIndex']);
        }

        if ($interviewSlotsTable->delete($slot)) {
            $this->Flash->success(__('Interview slot deleted.'));
        } else {
            $this->Flash->error(__('Failed to delete slot.'));
        }

        return $this->redirect(['action' => 'adminIndex']);
    }

    /**
     * Generate PDF letter for accepted/rejected applications
     */
    public function viewLetter($id = null)
    {
        $userId = $this->Authentication->getIdentity()->id;
        $isAdmin = $this->isAdmin();
        
        $application = $this->Applications->get($id, [
            'contain' => ['Users', 'InterviewSlots']
        ]);

        // Check access
        if (!$isAdmin && $application->user_id !== $userId) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'joinus']);
        }

        // Only generate letter for accepted/rejected
        if ($application->status === 'pending') {
            $this->Flash->error(__('Letter is only available for processed applications.'));
            return $this->redirect(['action' => 'joinus']);
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $isAccepted = $application->status === 'accepted';
        $statusColor = $isAccepted ? '#22c55e' : '#ef4444';
        $statusText = $isAccepted ? 'ACCEPTED' : 'REJECTED';

        $messageContent = $isAccepted 
            ? '<p style="font-size: 11px; line-height: 1.6; color: #374151; margin: 0;">
                <strong>Congratulations!</strong> Your application to join <strong>Persatuan Mahasiswa Hadhari (PMH)</strong> 
                has been <strong style="color: #22c55e;">ACCEPTED</strong>. Welcome to the PMH family! You will undergo a 
                <strong>one-semester trial period as an Adhoc member</strong>. Our team will contact you shortly.
               </p>'
            : '<p style="font-size: 11px; line-height: 1.6; color: #374151; margin: 0;">
                We regret to inform you that your application to join <strong>Persatuan Mahasiswa Hadhari (PMH)</strong> 
                has been <strong style="color: #ef4444;">REJECTED</strong>.
               </p>
               <p style="font-size: 11px; line-height: 1.6; color: #374151; margin: 8px 0 0 0;">
                <strong>Reason:</strong> ' . h($application->rejection_reason) . '
               </p>
               <p style="font-size: 11px; line-height: 1.6; color: #374151; margin: 8px 0 0 0;">
                We encourage you to try again in future application periods.
               </p>';

        $interviewInfo = $application->interview_slot 
            ? $application->interview_slot->interview_date->format('d M Y') . ' (' . $application->interview_slot->slot_time . ')'
            : 'N/A';

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                @page {
                    margin: 0;
                }
                * { box-sizing: border-box; margin: 0; padding: 0; }
                html, body { 
                    height: 100%; 
                    font-family: Arial, sans-serif; 
                    color: #1f2937; 
                    font-size: 11px;
                }
                .page-wrapper {
                    position: relative;
                    min-height: 100%;
                    height: 100%;
                }
                .header { 
                    background: linear-gradient(135deg, #7c2a7c 0%, #5a1f5a 100%); 
                    color: white; 
                    padding: 18px 30px; 
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                }
                .header-content { display: table; width: 100%; }
                .logo { display: table-cell; vertical-align: middle; }
                .logo-box { background: #edd134; color: #7c2a7c; font-weight: bold; font-size: 20px; padding: 12px 16px; display: inline-block; border-radius: 8px; }
                .org-info { display: table-cell; vertical-align: middle; text-align: right; }
                .org-name { font-size: 20px; font-weight: bold; }
                .org-subtitle { font-size: 11px; opacity: 0.9; margin-top: 3px; }
                
                .content { 
                    padding: 90px 30px 80px 30px;
                }
                .ref-number { background: #f3f4f6; padding: 10px 15px; border-radius: 6px; margin-bottom: 15px; font-size: 10px; color: #6b7280; }
                .status-badge { display: inline-block; background: ' . $statusColor . '; color: white; padding: 6px 18px; border-radius: 20px; font-weight: bold; font-size: 12px; margin-bottom: 12px; }
                .section-title { font-size: 13px; font-weight: bold; color: #7c2a7c; margin: 18px 0 10px 0; border-bottom: 2px solid #edd134; padding-bottom: 4px; }
                .info-grid { display: table; width: 100%; }
                .info-row { display: table-row; }
                .info-cell { display: table-cell; padding: 5px 0; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
                .info-cell.label { font-weight: 600; color: #6b7280; width: 30%; }
                .info-cell.value { color: #1f2937; }
                .message-box { background: #faf5ff; border-left: 4px solid #7c2a7c; padding: 15px; margin: 15px 0; border-radius: 0 8px 8px 0; }
                
                .auto-gen { 
                    background: #fef3c7; 
                    border: 1px solid #f59e0b; 
                    padding: 10px; 
                    border-radius: 6px; 
                    font-size: 10px; 
                    color: #92400e; 
                    text-align: center; 
                    margin-top: 25px;
                }
                
                .footer { 
                    background: #1f2937; 
                    color: white; 
                    padding: 15px 30px; 
                    font-size: 10px; 
                    text-align: center;
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                }
                .footer p { margin: 3px 0; }
            </style>
        </head>
        <body>
            <div class="page-wrapper">
                <div class="header">
                    <div class="header-content">
                        <div class="logo">
                            <div class="logo-box">PMH</div>
                        </div>
                        <div class="org-info">
                            <div class="org-name">Persatuan Mahasiswa Hadhari</div>
                            <div class="org-subtitle">UiTM Kampus Puncak Perdana | Official Membership Letter</div>
                        </div>
                    </div>
                </div>
                
                <div class="content">
                    <div class="ref-number">
                        <strong>Ref:</strong> PMH/APP/' . date('Y') . '/' . str_pad((string)$application->id, 4, '0', STR_PAD_LEFT) . ' &nbsp;|&nbsp; 
                        <strong>Date:</strong> ' . date('d F Y') . '
                    </div>
                    
                    <p style="font-size: 12px; color: #374151; margin: 0 0 12px 0;">Dear <strong>' . h($application->user->full_name) . '</strong>,</p>
                    
                    <div class="status-badge">' . $statusText . '</div>
                    
                    <div class="message-box">
                        ' . $messageContent . '
                    </div>
                    
                    <div class="section-title">APPLICANT DETAILS</div>
                    <div class="info-grid">
                        <div class="info-row"><div class="info-cell label">Full Name</div><div class="info-cell value">' . h($application->user->full_name) . '</div></div>
                        <div class="info-row"><div class="info-cell label">Matric Number</div><div class="info-cell value">' . h($application->user->matric_no) . '</div></div>
                        <div class="info-row"><div class="info-cell label">Email</div><div class="info-cell value">' . h($application->user->email) . '</div></div>
                        <div class="info-row"><div class="info-cell label">Phone</div><div class="info-cell value">' . h($application->user->phone_no) . '</div></div>
                        <div class="info-row"><div class="info-cell label">Gender / Semester</div><div class="info-cell value">' . h($application->gender) . ' / Semester ' . h($application->semester) . '</div></div>
                        <div class="info-row"><div class="info-cell label">CGPA</div><div class="info-cell value">' . number_format((float)$application->cgpa, 2) . '</div></div>
                        <div class="info-row"><div class="info-cell label">Interview</div><div class="info-cell value">' . $interviewInfo . '</div></div>
                        <div class="info-row"><div class="info-cell label">Applied On</div><div class="info-cell value">' . $application->created_at->format('d M Y, H:i') . '</div></div>
                    </div>
                    
                    <div class="auto-gen">
                        This is a computer-generated document. No signature is required.
                    </div>
                </div>
                
                <div class="footer">
                    <p><strong>Persatuan Mahasiswa Hadhari (PMH)</strong></p>
                    <p>Level 1, Kolej Jasmine, UiTM Puncak Perdana, Shah Alam, Selangor</p>
                    <p>Email: hello@mypmh.uitm.edu.my | Phone: +60 12-345 6789</p>
                </div>
            </div>
        </body>
        </html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $this->response = $this->response->withType('pdf');
        $this->response = $this->response->withHeader('Content-Disposition', 'inline; filename="PMH_Application_Letter_' . $application->id . '.pdf"');
        $this->response->getBody()->write($dompdf->output());
        return $this->response;
    }
}