<?php
declare(strict_types=1);

namespace App\Controller;

class PagesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['dashboard', 'about', 'contact', 'display']);
    }
    // Customer dashboard — home page after login
    public function dashboard()
    {
        $this->setCartCount();
        $identity = $this->Authentication->getIdentity();

        // Load promotions for marquee
        $Promotions = $this->fetchTable('Promotions');
        $promotions = $Promotions->find()
            ->where(['is_active' => 1])
            ->orderBy(['sort_order' => 'ASC'])
            ->all();

        // Load best sellers for slideshow
        $Products = $this->fetchTable('Products');
        $bestSellers = $Products->find()
            ->where(['is_best_seller' => 1, 'status' => 'open'])
            ->contain(['ProductLines'])
            ->limit(6)
            ->all();

        // Load new arrivals
        $newArrivals = $Products->find()
            ->where(['is_new_arrival' => 1, 'status' => 'open'])
            ->contain(['ProductLines'])
            ->limit(4)
            ->all();

        $this->set(compact('promotions', 'bestSellers', 'newArrivals', 'identity'));
    }

    // About Us page
    public function about()
    {
        $this->setCartCount();
        $Testimonials = $this->fetchTable('Testimonials');
        $testimonials = $Testimonials->find()
            ->where(['is_active' => 1])
            ->orderBy(['sort_order' => 'ASC'])
            ->all();
        $this->set(compact('testimonials'));
    }

    // Contact Us page (static with Google Maps)
    public function contact()
    {
        $this->setCartCount();
    }

    // Legacy display action (for backward compat if needed)
    public function display(string ...$path): ?\Cake\Http\Response
    {
        if (empty($path)) {
            return $this->redirect('/');
        }
        switch ($path[0]) {
            case 'dashboard': return $this->redirect(['action' => 'dashboard']);
            case 'aboutus':   return $this->redirect(['action' => 'about']);
            case 'contactus': return $this->redirect(['action' => 'contact']);
            default:          return $this->redirect('/dashboard');
        }
    }
}