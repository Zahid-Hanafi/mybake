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

        // Hardcoded promotions for marquee (removed DB table dependency)
        $promotions = [
            (object)['message' => 'Raya Special: 20% off all orders over RM150!'],
            (object)['message' => 'Free delivery for orders above RM100.'],
            (object)['message' => 'New Arrival: Kerepek Ubi BBQ Jumbo Pack is here!']
        ];

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
        // Hardcoded testimonials (removed DB table dependency)
        $testimonials = [
            (object)[
                'rating' => 5,
                'content' => 'The Bahulu Cermai reminds me of my grandmother’s cooking. Absolutely authentic and delicious!',
                'author_name' => 'Siti N.'
            ],
            (object)[
                'rating' => 5,
                'content' => 'Best Rempeyek Kacang Tanah I’ve had in years. So crispy and generous with the peanuts!',
                'author_name' => 'Ahmad F.'
            ],
            (object)[
                'rating' => 5,
                'content' => 'Packaging is great, shipping was fast, and the Kerepek Ubi BBQ is highly addictive!',
                'author_name' => 'Wong K.L.'
            ]
        ];
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