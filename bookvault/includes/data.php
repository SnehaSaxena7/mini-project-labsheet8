<?php
// ============================================================
// BookVault — Data Layer (flat-file, no DB required)
// ============================================================

session_start();

// ── Cart helpers ────────────────────────────────────────────
function cart_add($id, $qty = 1) {
    if (!isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id] = 0;
    $_SESSION['cart'][$id] += $qty;
}
function cart_remove($id) { unset($_SESSION['cart'][$id]); }
function cart_update($id, $qty) {
    if ($qty <= 0) cart_remove($id);
    else $_SESSION['cart'][$id] = $qty;
}
function cart_count() {
    if (empty($_SESSION['cart'])) return 0;
    return array_sum($_SESSION['cart']);
}
function cart_total($books) {
    $total = 0;
    foreach ($_SESSION['cart'] ?? [] as $id => $qty) {
        $b = get_book($id, $books);
        if ($b) $total += $b['price'] * $qty;
    }
    return $total;
}
function get_book($id, $books) {
    foreach ($books as $b) if ($b['id'] == $id) return $b;
    return null;
}

// ── Wishlist helpers ─────────────────────────────────────────
function wish_toggle($id) {
    if (in_array($id, $_SESSION['wishlist'] ?? [])) {
        $_SESSION['wishlist'] = array_diff($_SESSION['wishlist'], [$id]);
    } else {
        $_SESSION['wishlist'][] = $id;
    }
}
function is_wished($id) {
    return in_array($id, $_SESSION['wishlist'] ?? []);
}

// ── Books catalogue ──────────────────────────────────────────
$books = [
  // Fiction
  ['id'=>1,'title'=>'The Midnight Library','author'=>'Matt Haig','price'=>14.99,'original'=>19.99,'cover'=>'https://covers.openlibrary.org/b/id/10909258-L.jpg','cat'=>'Fiction','rating'=>4.7,'reviews'=>2841,'badge'=>'Bestseller','desc'=>'Between life and death there is a library, and within that library, the shelves go on forever. Every book provides a chance to try another life you could have lived.','stock'=>12],
  ['id'=>2,'title'=>'Lessons in Chemistry','author'=>'Bonnie Garmus','price'=>13.49,'original'=>18.00,'cover'=>'https://covers.openlibrary.org/b/id/12547129-L.jpg','cat'=>'Fiction','rating'=>4.6,'reviews'=>3102,'badge'=>'New','desc'=>'A chemist turned cooking show host in the 1960s who instructs her audience to approach life with the same experimental rigor they apply to chemistry.','stock'=>8],
  ['id'=>3,'title'=>'Tomorrow, and Tomorrow','author'=>'Gabrielle Zevin','price'=>15.99,'original'=>21.00,'cover'=>'https://covers.openlibrary.org/b/id/13183560-L.jpg','cat'=>'Fiction','rating'=>4.5,'reviews'=>1987,'badge'=>null,'desc'=>'A novel about love, art, identity, and the collision of the virtual and real worlds, spanning thirty years of friendship and creative partnership.','stock'=>5],
  ['id'=>4,'title'=>'Fourth Wing','author'=>'Rebecca Yarros','price'=>16.99,'original'=>24.00,'cover'=>'https://covers.openlibrary.org/b/id/14521893-L.jpg','cat'=>'Fiction','rating'=>4.8,'reviews'=>4501,'badge'=>'Hot','desc'=>'Enter the brutal and elite world of a war college for dragon riders, where magic, romance, and mortal danger intertwine.','stock'=>20],

  // Non-Fiction
  ['id'=>5,'title'=>'Atomic Habits','author'=>'James Clear','price'=>12.99,'original'=>17.99,'cover'=>'https://covers.openlibrary.org/b/id/10519503-L.jpg','cat'=>'Non-Fiction','rating'=>4.9,'reviews'=>9823,'badge'=>'Bestseller','desc'=>'An easy and proven way to build good habits and break bad ones. Transform your life with tiny changes that deliver remarkable results.','stock'=>30],
  ['id'=>6,'title'=>'Sapiens','author'=>'Yuval Noah Harari','price'=>13.99,'original'=>19.99,'cover'=>'https://covers.openlibrary.org/b/id/8302059-L.jpg','cat'=>'Non-Fiction','rating'=>4.7,'reviews'=>7621,'badge'=>null,'desc'=>'A brief history of humankind that explores how Homo sapiens came to dominate the Earth and examines what made us the rulers of the planet.','stock'=>15],
  ['id'=>7,'title'=>'The Body Keeps the Score','author'=>'Bessel van der Kolk','price'=>14.49,'original'=>20.00,'cover'=>'https://covers.openlibrary.org/b/id/10757102-L.jpg','cat'=>'Non-Fiction','rating'=>4.8,'reviews'=>5412,'badge'=>null,'desc'=>'Mind, brain, and body in the transformation of trauma. A groundbreaking work on how trauma reshapes body and brain.','stock'=>7],
  ['id'=>8,'title'=>'Hidden Potential','author'=>'Adam Grant','price'=>15.49,'original'=>22.00,'cover'=>'https://covers.openlibrary.org/b/id/14266268-L.jpg','cat'=>'Non-Fiction','rating'=>4.5,'reviews'=>1234,'badge'=>'New','desc'=>'The science of achieving greater things. Grant examines the systems that help people fulfill their potential and improve their skills.','stock'=>18],

  // Sci-Fi
  ['id'=>9,'title'=>'Project Hail Mary','author'=>'Andy Weir','price'=>13.99,'original'=>18.99,'cover'=>'https://covers.openlibrary.org/b/id/10527843-L.jpg','cat'=>'Sci-Fi','rating'=>4.9,'reviews'=>6234,'badge'=>'Bestseller','desc'=>'A lone astronaut must save the earth from disaster in this page-turning science-based thriller perfect for fans of The Martian.','stock'=>10],
  ['id'=>10,'title'=>'Dune','author'=>'Frank Herbert','price'=>11.99,'original'=>16.99,'cover'=>'https://covers.openlibrary.org/b/id/8231856-L.jpg','cat'=>'Sci-Fi','rating'=>4.8,'reviews'=>8901,'badge'=>'Classic','desc'=>'Set in the distant future amidst a feudal interstellar society, Dune tells the story of young Paul Atreides as he journeys to the desert planet Arrakis.','stock'=>25],
  ['id'=>11,'title'=>'The Hitchhiker\'s Guide','author'=>'Douglas Adams','price'=>9.99,'original'=>13.99,'cover'=>'https://covers.openlibrary.org/b/id/8406786-L.jpg','cat'=>'Sci-Fi','rating'=>4.8,'reviews'=>7412,'badge'=>'Classic','desc'=>'Seconds before Earth is demolished to make way for a hyperspace bypass, Arthur Dent is saved by his friend Ford Prefect, a researcher for the revised Hitchhiker\'s Guide to the Galaxy.','stock'=>22],
  ['id'=>12,'title'=>'Recursion','author'=>'Blake Crouch','price'=>12.49,'original'=>17.99,'cover'=>'https://covers.openlibrary.org/b/id/10520985-L.jpg','cat'=>'Sci-Fi','rating'=>4.6,'reviews'=>3201,'badge'=>null,'desc'=>'Reality is broken. At first, it seems like a disease — False Memory Syndrome — but what if it\'s something far more sinister?','stock'=>6],

  // Mystery
  ['id'=>13,'title'=>'The Thursday Murder Club','author'=>'Richard Osman','price'=>11.99,'original'=>16.99,'cover'=>'https://covers.openlibrary.org/b/id/10792948-L.jpg','cat'=>'Mystery','rating'=>4.5,'reviews'=>4102,'badge'=>null,'desc'=>'Four unlikely friends meet weekly to investigate unsolved crimes. When a real murder occurs on their doorstep, they find themselves in the middle of their first live case.','stock'=>14],
  ['id'=>14,'title'=>'In the Woods','author'=>'Tana French','price'=>10.99,'original'=>15.99,'cover'=>'https://covers.openlibrary.org/b/id/7222246-L.jpg','cat'=>'Mystery','rating'=>4.4,'reviews'=>2891,'badge'=>null,'desc'=>'A detective investigates the murder of a young girl in the same woods where, as a child, he was the sole survivor of a traumatic event.','stock'=>9],
  ['id'=>15,'title'=>'Verity','author'=>'Colleen Hoover','price'=>12.99,'original'=>17.99,'cover'=>'https://covers.openlibrary.org/b/id/12663417-L.jpg','cat'=>'Mystery','rating'=>4.7,'reviews'=>5621,'badge'=>'Hot','desc'=>'A struggling writer accepts a lucrative job completing a renowned thriller author\'s series—but what she finds in the house will change her life forever.','stock'=>11],
  ['id'=>16,'title'=>'Holly','author'=>'Stephen King','price'=>14.99,'original'=>21.99,'cover'=>'https://covers.openlibrary.org/b/id/13742096-L.jpg','cat'=>'Mystery','rating'=>4.6,'reviews'=>2341,'badge'=>'New','desc'=>'A brilliant, haunting, and unforgettable thriller novel from the legendary Stephen King featuring beloved character Holly Gibney.','stock'=>8],
];

$categories = ['All', 'Fiction', 'Non-Fiction', 'Sci-Fi', 'Mystery'];
