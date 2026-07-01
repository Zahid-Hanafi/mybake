<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'register', 'logout']);
    }

    // ── Login ──────────────────────────────────────────────────────────────
    public function login()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        // If already authenticated via session and this is a GET, redirect appropriately
        if ($this->request->is('get') && $result->isValid()) {
            $identity = $this->Authentication->getIdentity();
            if ($identity->get('role') === 'admin') {
                return $this->redirect(['controller' => 'Admin', 'action' => 'dashboard']);
            }
            return $this->redirect(['controller' => 'Pages', 'action' => 'dashboard']);
        }

        // Handle POST (form submission)
        if ($this->request->is('post')) {
            $selectedRole = $this->request->getData('role');

            if ($result->isValid()) {
                $identity = $this->Authentication->getIdentity();

                // Role mismatch check
                if (empty($selectedRole) || $identity->get('role') !== $selectedRole) {
                    $this->Authentication->logout();
                    if ($selectedRole === 'admin') {
                        $this->Flash->error(__('Access denied. This account is not an Admin. Please select Customer.'));
                    } else {
                        $this->Flash->error(__('Access denied. Admins must select the Admin option to login.'));
                    }
                    return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                }

                // Redirect by role
                if ($identity->get('role') === 'admin') {
                    return $this->redirect(['controller' => 'Admin', 'action' => 'dashboard']);
                }
                return $this->redirect(['controller' => 'Pages', 'action' => 'dashboard']);
            }

            // Authentication failed
            $this->Flash->error(__('Invalid email or password. Please try again.'));
            // Do not redirect on failure, render the form directly so the flash message shows
            // without relying on session persistence across redirects on localhost.
        }
    }

    // ── Register ───────────────────────────────────────────────────────────
    public function register()
    {
        $this->viewBuilder()->setLayout('ajax');
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Validate confirm password before patching
            if (empty($data['confirm_password']) || $data['password'] !== $data['confirm_password']) {
                $this->Flash->error(__('Passwords do not match. Please try again.'));
                $this->set(compact('user'));
                return;
            }

            $user = $this->Users->patchEntity($user, $data);
            $user->role   = 'customer';
            $user->status = 'active';

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registration successful! Please login with your email and password.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }

            // Collect validation errors for display
            $errors = [];
            foreach ($user->getErrors() as $field => $msgs) {
                foreach ($msgs as $msg) {
                    $errors[] = $msg;
                }
            }
            if ($errors) {
                $this->Flash->error(implode(' | ', $errors));
            } else {
                $this->Flash->error(__('Registration failed. Please check your details.'));
            }
        }

        $this->set(compact('user'));
    }

    // ── Logout ─────────────────────────────────────────────────────────────
    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    // ── Profile ────────────────────────────────────────────────────────────
    public function profile()
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();
        $user     = $this->Users->get($identity->get('id'), ['contain' => ['Addresses']]);

        if ($this->request->is(['post', 'put'])) {
            $data   = $this->request->getData();
            $fields = ['first_name', 'last_name', 'phone_no'];

            if (!empty($data['password'])) {
                $fields[] = 'password';
            } else {
                unset($data['password'], $data['confirm_password']);
            }

            $user = $this->Users->patchEntity($user, $data, [
                'validate' => 'profile',
                'fields'   => $fields,
            ]);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Profile updated successfully!'));
                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('Could not update profile. Please check your input.'));
        }

        $this->set(compact('user'));
    }
}