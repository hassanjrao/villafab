<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ─── Frontend Routes ──────────────────────────────────────────────────────────

// Main pages
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/instructions', [FrontendController::class, 'instructions'])->name('instructions');
Route::get('/your-hosts', [FrontendController::class, 'yourHosts'])->name('your-hosts');
Route::get('/book-now', [FrontendController::class, 'bookNow'])->name('book-now');
Route::get('/kitchen', [FrontendController::class, 'kitchen'])->name('kitchen');
Route::get('/events', [FrontendController::class, 'events'])->name('events');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');

// Contact form submission
Route::post('/contact', [FrontendController::class, 'contact'])->name('contact');

// Gallery sub-pages
Route::get('/the-rooms', [FrontendController::class, 'theRooms'])->name('the-rooms');
Route::get('/game-rooms', [FrontendController::class, 'gameRooms'])->name('game-rooms');
Route::get('/bridal-suite', [FrontendController::class, 'bridalSuite'])->name('bridal-suite');
Route::get('/the-pool', [FrontendController::class, 'thePool'])->name('the-pool');
Route::get('/miniature-golf-course', [FrontendController::class, 'miniatureGolfCourse'])->name('miniature-golf-course');
Route::get('/the-sports-area', [FrontendController::class, 'theSportsArea'])->name('the-sports-area');
Route::get('/birds-eye', [FrontendController::class, 'birdsEye'])->name('birds-eye');
Route::get('/floorplan', [FrontendController::class, 'floorplan'])->name('floorplan');

// Experiences
Route::get('/wineries', [FrontendController::class, 'wineries'])->name('wineries');
Route::get('/temecula', [FrontendController::class, 'temecula'])->name('temecula');
Route::get('/team-bonding', [FrontendController::class, 'teamBonding'])->name('team-bonding');
Route::get('/favorite-wineries', [FrontendController::class, 'favoriteWineries'])->name('favorite-wineries');
Route::get('/maps', [FrontendController::class, 'maps'])->name('maps');

// Team-bonding game pages
Route::get('/balloon-race', [FrontendController::class, 'balloonRace'])->name('balloon-race');
Route::get('/butt-balloon', [FrontendController::class, 'buttBalloon'])->name('butt-balloon');
Route::get('/legs-tied', [FrontendController::class, 'legsTied'])->name('legs-tied');
Route::get('/mine-fields', [FrontendController::class, 'mineFields'])->name('mine-fields');
Route::get('/pass-the-ball', [FrontendController::class, 'passTheBall'])->name('pass-the-ball');
Route::get('/pass-the-block', [FrontendController::class, 'passTheBlock'])->name('pass-the-block');
Route::get('/ping-pong-in-a-cup', [FrontendController::class, 'pingPongInACup'])->name('ping-pong-in-a-cup');
Route::get('/rope-escape', [FrontendController::class, 'ropeEscape'])->name('rope-escape');
Route::get('/stuck-on-paper', [FrontendController::class, 'stuckOnPaper'])->name('stuck-on-paper');
Route::get('/the-nuts-stacker', [FrontendController::class, 'theNutsStacker'])->name('the-nuts-stacker');

// SEO pages
Route::get('/airbnb', [FrontendController::class, 'airbnb'])->name('airbnb');
Route::get('/vrbo', [FrontendController::class, 'vrbo'])->name('vrbo');
Route::get('/trip-advisor', [FrontendController::class, 'tripAdvisor'])->name('trip-advisor');
Route::get('/booking', [FrontendController::class, 'booking'])->name('booking');
Route::get('/expedia', [FrontendController::class, 'expedia'])->name('expedia');

// Retreat pages (flattened from subdirectories)
Route::get('/villa-fabulosa', [FrontendController::class, 'villaFabulosa'])->name('villa-fabulosa');
Route::get('/short-term-rental', [FrontendController::class, 'shortTermRental'])->name('short-term-rental');
Route::get('/corporate-retreats', [FrontendController::class, 'corporateRetreats'])->name('corporate-retreats');
Route::get('/meditation-retreats', [FrontendController::class, 'meditationRetreats'])->name('meditation-retreats');
Route::get('/yoga-retreats', [FrontendController::class, 'yogaRetreats'])->name('yoga-retreats');
Route::get('/spiritual-retreats', [FrontendController::class, 'spiritualRetreats'])->name('spiritual-retreats');
Route::get('/nature-retreats', [FrontendController::class, 'natureRetreats'])->name('nature-retreats');
Route::get('/couples-retreats', [FrontendController::class, 'couplesRetreats'])->name('couples-retreats');
Route::get('/fitness-retreats', [FrontendController::class, 'fitnessRetreats'])->name('fitness-retreats');
Route::get('/digital-detox-retreats', [FrontendController::class, 'digitalDetoxRetreats'])->name('digital-detox-retreats');
Route::get('/weight-loss-retreats', [FrontendController::class, 'weightLossRetreats'])->name('weight-loss-retreats');
Route::get('/detox-retreats', [FrontendController::class, 'detoxRetreats'])->name('detox-retreats');
Route::get('/spa-retreats', [FrontendController::class, 'spaRetreats'])->name('spa-retreats');

// ─── Admin / Backend Routes ───────────────────────────────────────────────────

Route::match(['get', 'post'], '/dashboard', function () {
    return view('dashboard');
});
Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');
