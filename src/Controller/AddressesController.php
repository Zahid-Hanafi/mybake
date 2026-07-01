<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

class AddressesController extends AppController
{
    public function index(): void
    {
        $this->setCartCount();
        $identity  = $this->Authentication->getIdentity();
        $addresses = $this->Addresses->find()
            ->where(['user_id' => $identity->get('id')])
            ->order(['is_default' => 'DESC', 'created_at' => 'ASC'])
            ->all();
        $this->set(compact('addresses'));
    }

    public function add(): Response|null
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();
        $address  = $this->Addresses->newEmptyEntity();

        if ($this->request->is('post')) {
            $address = $this->Addresses->patchEntity($address, $this->request->getData());
            $address->user_id = $identity->get('id');

            // If this is the first address, set as default
            $count = $this->Addresses->find()->where(['user_id' => $identity->get('id')])->count();
            if ($count === 0 || (bool)$this->request->getData('is_default')) {
                $this->Addresses->updateAll(['is_default' => 0], ['user_id' => $identity->get('id')]);
                $address->is_default = 1;
            }

            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('Address added successfully!'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not save address.'));
        }

        $this->set(compact('address'));
        return null;
    }

    public function edit(int $id): Response|null
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();
        $address  = $this->Addresses->get($id);

        if ($address->user_id !== $identity->get('id')) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $address = $this->Addresses->patchEntity($address, $this->request->getData());

            if ((bool)$this->request->getData('is_default')) {
                $this->Addresses->updateAll(['is_default' => 0], ['user_id' => $identity->get('id')]);
                $address->is_default = 1;
            }

            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('Address updated successfully!'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not update address.'));
        }

        $this->set(compact('address'));
        return null;
    }

    public function delete(int $id): Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $identity = $this->Authentication->getIdentity();
        $address  = $this->Addresses->get($id);

        if ($address->user_id !== $identity->get('id')) {
            $this->Flash->error(__('Access denied.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Addresses->delete($address);
        $this->Flash->success(__('Address removed.'));
        return $this->redirect(['action' => 'index']);
    }

    public function setDefault(int $id): Response
    {
        $this->request->allowMethod(['post']);
        $identity = $this->Authentication->getIdentity();
        $address  = $this->Addresses->get($id);

        if ($address->user_id !== $identity->get('id')) {
            return $this->response->withStatus(403)->withStringBody(json_encode(['error' => 'Forbidden']));
        }

        $this->Addresses->updateAll(['is_default' => 0], ['user_id' => $identity->get('id')]);
        $address->is_default = 1;
        $this->Addresses->save($address);

        return $this->response->withType('json')->withStringBody(json_encode(['success' => true]));
    }
}
