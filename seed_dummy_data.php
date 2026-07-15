<?php
/**
 * Seed Script: 50 Malaysian customers + orders spanning Jan 2024 – Jul 2026
 * Run once: php seed_dummy_data.php
 */
require __DIR__ . '/vendor/autoload.php';

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

// Bootstrap minimal CakePHP
Configure::write('App.namespace', 'App');
$dsn = 'mysql://root@localhost/mybake?encoding=utf8mb4&timezone=%2B08:00';
ConnectionManager::setConfig('default', ['url' => $dsn]);
$conn = ConnectionManager::get('default');

echo "=== MyBake Dummy Data Seeder ===\n\n";

// 1. Clean up existing customers (keep id=1 admin, id=2 zahid)
echo "[1] Cleaning up old customer accounts...\n";
$conn->execute("DELETE FROM order_status_logs WHERE order_id IN (SELECT id FROM orders WHERE user_id NOT IN (1,2))");
$conn->execute("DELETE FROM order_items WHERE order_id IN (SELECT id FROM orders WHERE user_id NOT IN (1,2))");
$conn->execute("DELETE FROM orders WHERE user_id NOT IN (1,2)");
$conn->execute("DELETE FROM cart_items WHERE cart_id IN (SELECT id FROM carts WHERE user_id NOT IN (1,2))");
$conn->execute("DELETE FROM carts WHERE user_id NOT IN (1,2)");
$conn->execute("DELETE FROM addresses WHERE user_id NOT IN (1,2)");
$conn->execute("DELETE FROM users WHERE id NOT IN (1,2)");
echo "   Done. Kept admin@mybake.com and zahid@gmail.com\n\n";

// 2. Insert 50 Malaysian customers
echo "[2] Inserting 50 Malaysian customers...\n";
$password = password_hash('Customer@123', PASSWORD_DEFAULT);

$customers = [
    ['Nurul', 'Aisyah', 'nurul.aisyah@gmail.com', '0123456789', 'No 12, Jalan Mawar 3, Taman Melati, 53100 Kuala Lumpur'],
    ['Muhammad', 'Irfan', 'muhammad.irfan@gmail.com', '0134567890', 'B-3-12, Kondominium Seri Maya, Jalan Gombak, 53000 Kuala Lumpur'],
    ['Siti', 'Nur Amira', 'siti.amira@gmail.com', '0145678901', 'No 45, Lorong Delima 5, Taman Desa Jaya, 81100 Johor Bahru'],
    ['Amirul', 'Hakim', 'amirul.hakim@gmail.com', '0156789012', '23A, Jalan Hang Tuah, 75300 Melaka'],
    ['Farah', 'Diana', 'farah.diana@gmail.com', '0167890123', 'Lot 8, Persiaran Gurney, 10250 Pulau Pinang'],
    ['Mohd', 'Azlan', 'mohd.azlan@gmail.com', '0178901234', 'No 7, Jalan Sultan Ismail, 20200 Kuala Terengganu'],
    ['Nur', 'Hidayah', 'nur.hidayah@gmail.com', '0189012345', 'Blok C-4-7, Pangsapuri Harmoni, 40150 Shah Alam, Selangor'],
    ['Ahmad', 'Firdaus', 'ahmad.firdaus@gmail.com', '0112345678', '56, Jalan Dato Onn, 50480 Kuala Lumpur'],
    ['Aisyah', 'Humaira', 'aisyah.humaira@gmail.com', '0123456780', 'No 33, Taman Sri Pulai, 81300 Skudai, Johor'],
    ['Hafiz', 'Rahman', 'hafiz.rahman@gmail.com', '0134567891', '12, Jalan Teluk Likas, 88400 Kota Kinabalu, Sabah'],
    ['Syafiqah', 'Mohd Nor', 'syafiqah.nor@gmail.com', '0145678902', 'No 88, Jalan Kuching, 51200 Kuala Lumpur'],
    ['Danial', 'Haiqal', 'danial.haiqal@gmail.com', '0156789013', 'A-12-5, Vista Komanwel, 57000 Bukit Jalil, KL'],
    ['Nabilah', 'Zainal', 'nabilah.zainal@gmail.com', '0167890124', '34, Jalan Taiping, 30010 Ipoh, Perak'],
    ['Izzat', 'Syahmi', 'izzat.syahmi@gmail.com', '0178901235', 'No 5, Lorong Setiawangsa 3, 54200 Kuala Lumpur'],
    ['Fatimah', 'Zahara', 'fatimah.zahara@gmail.com', '0189012346', '22, Jalan Merbau, Taman Universiti, 81300 Johor Bahru'],
    ['Arif', 'Budiman', 'arif.budiman@gmail.com', '0112345679', 'No 67, Jalan Raja Muda, 42000 Port Klang, Selangor'],
    ['Wardina', 'Safiyyah', 'wardina.safiyyah@gmail.com', '0123456781', '15A, Jalan SS2/55, 47300 Petaling Jaya, Selangor'],
    ['Imran', 'Hakimi', 'imran.hakimi@gmail.com', '0134567892', 'Lot 23, Jalan Bukit Bintang, 55100 Kuala Lumpur'],
    ['Hana', 'Solehah', 'hana.solehah@gmail.com', '0145678903', 'No 9, Taman Desa Skudai, 81300 Johor'],
    ['Zulkifli', 'Ibrahim', 'zulkifli.ibrahim@gmail.com', '0156789014', '47, Jalan Ampang, 50450 Kuala Lumpur'],
    ['Liyana', 'Afiqah', 'liyana.afiqah@gmail.com', '0167890125', 'B-7-3, Menara KLH, 53300 Setapak, KL'],
    ['Rizal', 'Ashraf', 'rizal.ashraf@gmail.com', '0178901236', 'No 18, Jalan Dato Keramat, 10150 Pulau Pinang'],
    ['Maisarah', 'Hanim', 'maisarah.hanim@gmail.com', '0189012347', '30, Lorong Hang Jebat, 75200 Melaka'],
    ['Khairul', 'Anwar', 'khairul.anwar@gmail.com', '0112345680', 'No 55, Taman Cempaka, 25200 Kuantan, Pahang'],
    ['Ain', 'Nabila', 'ain.nabila@gmail.com', '0123456782', '8A, Jalan USJ 9/5P, 47620 Subang Jaya, Selangor'],
    ['Faisal', 'Amin', 'faisal.amin@gmail.com', '0134567893', '21, Jalan Sultanah, 05000 Alor Setar, Kedah'],
    ['Diyana', 'Rosli', 'diyana.rosli@gmail.com', '0145678904', 'No 14, Taman Pelangi Indah, 81800 Ulu Tiram, Johor'],
    ['Haziq', 'Iskandar', 'haziq.iskandar@gmail.com', '0156789015', '39, Jalan Raja Laut, 50350 Kuala Lumpur'],
    ['Balqis', 'Adawiyah', 'balqis.adawiyah@gmail.com', '0167890126', 'C-2-10, Residensi Alam Damai, 56000 Cheras, KL'],
    ['Nizam', 'Harun', 'nizam.harun@gmail.com', '0178901237', 'No 73, Jalan Besar, 15000 Kota Bharu, Kelantan'],
    ['Puteri', 'Intan', 'puteri.intan@gmail.com', '0189012348', '16, Jalan Tuanku Abdul Rahman, 10100 Pulau Pinang'],
    ['Aiman', 'Zafran', 'aiman.zafran@gmail.com', '0112345681', 'Lot 42, Taman Maju, 93400 Kuching, Sarawak'],
    ['Mariam', 'Jamilah', 'mariam.jamilah@gmail.com', '0123456783', 'No 28, Jalan PJS 8/5, 46150 Bandar Sunway, Selangor'],
    ['Hakeem', 'Luqman', 'hakeem.luqman@gmail.com', '0134567894', '5, Lorong Hang Kasturi, 75050 Melaka'],
    ['Iffah', 'Humaira', 'iffah.humaira@gmail.com', '0145678905', 'A-8-2, Kondominium Tropika, 47400 Petaling Jaya'],
    ['Taufiq', 'Hidayat', 'taufiq.hidayat@gmail.com', '0156789016', 'No 61, Jalan Semantan, 50490 Kuala Lumpur'],
    ['Zara', 'Aqilah', 'zara.aqilah@gmail.com', '0167890127', '19, Taman Desa Cemerlang, 81800 Johor Bahru'],
    ['Luqman', 'Hakimi', 'luqman.hakimi@gmail.com', '0178901238', 'Blok D-5-3, Flat Sri Pahang, 59200 Bangsar, KL'],
    ['Safura', 'Idris', 'safura.idris@gmail.com', '0189012349', 'No 37, Jalan Bunga Raya, 25000 Kuantan, Pahang'],
    ['Yusuf', 'Hakim', 'yusuf.hakim@gmail.com', '0112345682', '48, Jalan Bakar Batu, 80100 Johor Bahru'],
    ['Athirah', 'Sofea', 'athirah.sofea@gmail.com', '0123456784', 'No 10, Lorong Perak, 10150 Pulau Pinang'],
    ['Harith', 'Danish', 'harith.danish@gmail.com', '0134567895', '26, Jalan Jelutong, 11600 Pulau Pinang'],
    ['Yasmin', 'Nabihah', 'yasmin.nabihah@gmail.com', '0145678906', 'B-4-8, Pangsapuri Seri Nilam, 68100 Batu Caves, Selangor'],
    ['Farhan', 'Aqil', 'farhan.aqil@gmail.com', '0156789017', 'No 82, Taman Merdeka, 06000 Jitra, Kedah'],
    ['Umairah', 'Batrisyia', 'umairah.batrisyia@gmail.com', '0167890128', '3, Jalan Pantai Baru, 59200 Kuala Lumpur'],
    ['Danish', 'Mikail', 'danish.mikail@gmail.com', '0178901239', 'No 51, Taman Bukit Indah, 79100 Iskandar Puteri, Johor'],
    ['Hanis', 'Zalikha', 'hanis.zalikha@gmail.com', '0189012350', '14A, Jalan Ipoh, 51200 Kuala Lumpur'],
    ['Qayyum', 'Rafiq', 'qayyum.rafiq@gmail.com', '0112345683', 'Lot 31, Jalan Pending, 93450 Kuching, Sarawak'],
    ['Irdina', 'Hasanah', 'irdina.hasanah@gmail.com', '0123456785', 'No 20, Lorong Ciku, Taman Kota Masai, 81700 Pasir Gudang, Johor'],
    ['Aslam', 'Mukhriz', 'aslam.mukhriz@gmail.com', '0134567896', '77, Jalan Tun Razak, 50400 Kuala Lumpur'],
];

$insertedUserIds = [];
foreach ($customers as $c) {
    $conn->execute(
        "INSERT INTO users (first_name, last_name, email, phone_no, password, role, status, created_at) VALUES (?, ?, ?, ?, ?, 'customer', 'active', NOW())",
        [$c[0], $c[1], $c[2], $c[3], $password]
    );
    $insertedUserIds[] = (int)$conn->execute("SELECT LAST_INSERT_ID() as id")->fetch('assoc')['id'];
}
echo "   Inserted " . count($insertedUserIds) . " customers.\n\n";

// Include zahid (id=2) in the pool for orders
$allCustomerIds = array_merge([2], $insertedUserIds);

// 3. Restock all products
echo "[3] Restocking all products to 500...\n";
$conn->execute("UPDATE products SET stock_quantity = 500, status = 'open'");
echo "   Done.\n\n";

// 4. Products data
$products = $conn->execute("SELECT id, name, price FROM products ORDER BY id")->fetchAll('assoc');
$productCount = count($products);

// 5. Generate Orders (Jan 2024 - Jul 2026)
echo "[4] Generating orders across Jan 2024 - Jul 2026...\n";

$orderCount = 0;
$startYear = 2024;
$endYear = 2026;
$endMonth = 7;

$courierName = 'Pos Laju';

for ($year = $startYear; $year <= $endYear; $year++) {
    $maxMonth = ($year === $endYear) ? $endMonth : 12;
    for ($month = 1; $month <= $maxMonth; $month++) {
        $ordersThisMonth = rand(12, 20);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($o = 0; $o < $ordersThisMonth; $o++) {
            $day = rand(1, $daysInMonth);
            $hour = rand(8, 22);
            $minute = rand(0, 59);
            $orderDate = sprintf('%04d-%02d-%02d %02d:%02d:00', $year, $month, $day, $hour, $minute);

            $customerId = $allCustomerIds[array_rand($allCustomerIds)];

            $customer = $conn->execute("SELECT first_name, last_name, phone_no FROM users WHERE id = ?", [$customerId])->fetch('assoc');

            $addressIndex = array_search($customerId, $allCustomerIds);
            $deliveryAddress = ($addressIndex !== false && $addressIndex > 0 && isset($customers[$addressIndex - 1]))
                ? $customers[$addressIndex - 1][4]
                : 'No 1, Jalan Utama, 50000 Kuala Lumpur';
            if ($customerId === 2) {
                $deliveryAddress = 'Bandar Tasik Selatan, 2-04-10, Cheras, Kuala Lumpur, 57000';
            }

            $numProducts = rand(1, 4);
            $chosenProducts = array_rand($products, min($numProducts, $productCount));
            if (!is_array($chosenProducts)) $chosenProducts = [$chosenProducts];

            $totalAmount = 0;
            $orderItems = [];
            foreach ($chosenProducts as $pi) {
                $p = $products[$pi];
                $qty = rand(1, 8);
                $subtotal = $p['price'] * $qty;
                $totalAmount += $subtotal;
                $orderItems[] = [
                    'product_id' => $p['id'],
                    'product_name' => $p['name'],
                    'unit_price' => $p['price'],
                    'cost_price' => round($p['price'] * 0.5, 2),
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
            }

            $orderTimestamp = strtotime($orderDate);
            $now = time();
            $daysOld = ($now - $orderTimestamp) / 86400;

            if ($daysOld > 30) {
                $status = (rand(1, 10) <= 8) ? 'complete' : 'cancelled';
            } elseif ($daysOld > 7) {
                $status = (rand(1, 10) <= 6) ? 'complete' : 'shipping';
            } else {
                $status = (rand(1, 10) <= 5) ? 'preparing' : 'shipping';
            }

            $qrToken = bin2hex(random_bytes(32));
            $trackingNumber = null;
            $shippedAt = null;
            $completedAt = null;

            if ($status === 'shipping' || $status === 'complete') {
                $shippedAt = date('Y-m-d H:i:s', $orderTimestamp + rand(86400, 172800));
                $trackingNumber = 'EN' . rand(100000000, 999999999) . 'MY';
            }
            if ($status === 'complete') {
                $completedAt = date('Y-m-d H:i:s', strtotime($shippedAt) + rand(172800, 604800));
            }

            $conn->execute(
                "INSERT INTO orders (user_id, delivery_address, phone_no, total_amount, status, qr_token, courier_name, tracking_number, shipped_at, completed_at, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [$customerId, $deliveryAddress, $customer['phone_no'], $totalAmount, $status, $qrToken,
                 ($status === 'shipping' || $status === 'complete') ? $courierName : null,
                 $trackingNumber, $shippedAt, $completedAt, $orderDate]
            );
            $orderId = (int)$conn->execute("SELECT LAST_INSERT_ID() as id")->fetch('assoc')['id'];

            foreach ($orderItems as $item) {
                $conn->execute(
                    "INSERT INTO order_items (order_id, product_id, product_name, unit_price, cost_price, quantity, subtotal, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                    [$orderId, $item['product_id'], $item['product_name'], $item['unit_price'], $item['cost_price'], $item['quantity'], $item['subtotal'], $orderDate]
                );
            }

            $conn->execute(
                "INSERT INTO order_status_logs (order_id, status, note, created_by, created_at) VALUES (?, 'preparing', 'Order placed', ?, ?)",
                [$orderId, $customerId, $orderDate]
            );
            if ($status === 'shipping' || $status === 'complete') {
                $conn->execute(
                    "INSERT INTO order_status_logs (order_id, status, note, created_by, created_at) VALUES (?, 'shipping', ?, 1, ?)",
                    [$orderId, "Shipped via Pos Laju - Tracking: {$trackingNumber}", $shippedAt]
                );
            }
            if ($status === 'complete') {
                $conn->execute(
                    "INSERT INTO order_status_logs (order_id, status, note, created_by, created_at) VALUES (?, 'complete', 'Order completed', 1, ?)",
                    [$orderId, $completedAt]
                );
            }

            $orderCount++;
        }
    }
}
echo "   Generated {$orderCount} orders.\n\n";

// 6. Generate Offline Sales (Jan 2024 - Jul 2026)
echo "[5] Generating offline sales records...\n";
$offlineCount = 0;

for ($year = $startYear; $year <= $endYear; $year++) {
    $maxMonth = ($year === $endYear) ? $endMonth : 12;
    for ($month = 1; $month <= $maxMonth; $month++) {
        $salesThisMonth = rand(1, 3);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($s = 0; $s < $salesThisMonth; $s++) {
            $day = rand(1, $daysInMonth);
            $saleDate = sprintf('%04d-%02d-%02d', $year, $month, $day);

            $numProducts = rand(2, 5);
            $chosenProducts = array_rand($products, min($numProducts, $productCount));
            if (!is_array($chosenProducts)) $chosenProducts = [$chosenProducts];

            $totalAmount = 0;
            $saleItems = [];
            foreach ($chosenProducts as $pi) {
                $p = $products[$pi];
                $qty = rand(3, 20);
                $subtotal = $p['price'] * $qty;
                $totalAmount += $subtotal;
                $saleItems[] = [
                    'product_id' => $p['id'],
                    'product_name' => $p['name'],
                    'unit_price' => $p['price'],
                    'cost_price' => round($p['price'] * 0.5, 2),
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
            }

            $conn->execute(
                "INSERT INTO offline_sales (recorded_by, sale_date, total_amount, notes, created_at) VALUES (1, ?, ?, '', ?)",
                [$saleDate, $totalAmount, $saleDate . ' 10:00:00']
            );
            $saleId = (int)$conn->execute("SELECT LAST_INSERT_ID() as id")->fetch('assoc')['id'];

            foreach ($saleItems as $item) {
                $conn->execute(
                    "INSERT INTO offline_sale_items (offline_sale_id, product_id, product_name, unit_price, cost_price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?)",
                    [$saleId, $item['product_id'], $item['product_name'], $item['unit_price'], $item['cost_price'], $item['quantity'], $item['subtotal']]
                );
            }

            $offlineCount++;
        }
    }
}
echo "   Generated {$offlineCount} offline sales records.\n\n";

// Summary
$totalUsers = $conn->execute("SELECT COUNT(*) as c FROM users WHERE role='customer'")->fetch('assoc')['c'];
$totalOrders = $conn->execute("SELECT COUNT(*) as c FROM orders")->fetch('assoc')['c'];
$totalOffline = $conn->execute("SELECT COUNT(*) as c FROM offline_sales")->fetch('assoc')['c'];

echo "=== SEEDING COMPLETE ===\n";
echo "Total customers: {$totalUsers}\n";
echo "Total orders: {$totalOrders}\n";
echo "Total offline sales: {$totalOffline}\n";
echo "All products restocked to 500 units.\n";
echo "========================\n";
