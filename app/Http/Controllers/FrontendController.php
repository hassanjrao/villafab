<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    // ─── Main Pages ──────────────────────────────────────────────────────────

    public function home()
    {
        return view('frontend.home');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function instructions()
    {
        return view('frontend.instructions');
    }

    public function yourHosts()
    {
        return view('frontend.your-hosts');
    }

    public function bookNow(Request $request)
    {
        return view('frontend.book-now', [
            'checkin'  => $request->query('checkin', ''),
            'checkout' => $request->query('checkout', ''),
            'guests'   => max(1, (int) $request->query('guests', 1)),
        ]);
    }

    public function kitchen()
    {
        return view('frontend.kitchen');
    }

    public function events()
    {
        return view('frontend.events');
    }

    public function gallery()
    {
        return view('frontend.gallery');
    }

    // ─── Gallery Sub-pages ────────────────────────────────────────────────────

    public function theRooms()
    {
        return view('frontend.gallery.the-rooms');
    }

    public function gameRooms()
    {
        return view('frontend.gallery.game-rooms');
    }

    public function bridalSuite()
    {
        return view('frontend.gallery.bridal-suite');
    }

    public function thePool()
    {
        return view('frontend.gallery.the-pool');
    }

    public function miniatureGolfCourse()
    {
        return view('frontend.gallery.miniature-golf-course');
    }

    public function theSportsArea()
    {
        return view('frontend.gallery.the-sports-area');
    }

    public function birdsEye()
    {
        return view('frontend.gallery.birds-eye');
    }

    public function floorplan()
    {
        return view('frontend.gallery.floorplan');
    }

    // ─── Experiences ──────────────────────────────────────────────────────────

    public function wineries()
    {
        return view('frontend.experiences.wineries');
    }

    public function temecula()
    {
        return view('frontend.experiences.temecula');
    }

    public function teamBonding()
    {
        return view('frontend.experiences.team-bonding');
    }

    public function favoriteWineries()
    {
        return view('frontend.experiences.favorite-wineries');
    }

    public function maps()
    {
        return view('frontend.experiences.maps');
    }

    // ─── Team-Bonding Games ───────────────────────────────────────────────────

    public function balloonRace()
    {
        return view('frontend.games.balloon-race');
    }

    public function buttBalloon()
    {
        return view('frontend.games.butt-balloon');
    }

    public function legsTied()
    {
        return view('frontend.games.legs-tied');
    }

    public function mineFields()
    {
        return view('frontend.games.mine-fields');
    }

    public function passTheBall()
    {
        return view('frontend.games.pass-the-ball');
    }

    public function passTheBlock()
    {
        return view('frontend.games.pass-the-block');
    }

    public function pingPongInACup()
    {
        return view('frontend.games.ping-pong-in-a-cup');
    }

    public function ropeEscape()
    {
        return view('frontend.games.rope-escape');
    }

    public function stuckOnPaper()
    {
        return view('frontend.games.stuck-on-paper');
    }

    public function theNutsStacker()
    {
        return view('frontend.games.the-nuts-stacker');
    }

    // ─── SEO Pages ────────────────────────────────────────────────────────────

    public function airbnb()
    {
        return view('frontend.seo.airbnb');
    }

    public function vrbo()
    {
        return view('frontend.seo.vrbo');
    }

    public function tripAdvisor()
    {
        return view('frontend.seo.trip-advisor');
    }

    public function booking()
    {
        return view('frontend.seo.booking');
    }

    public function expedia()
    {
        return view('frontend.seo.expedia-link');
    }

    // ─── Retreat Pages ────────────────────────────────────────────────────────

    public function villaFabulosa()
    {
        return view('frontend.retreats.villa-fabulosa');
    }

    public function shortTermRental()
    {
        return view('frontend.retreats.short-term-rental');
    }

    public function corporateRetreats()
    {
        return view('frontend.retreats.corporate-retreats');
    }

    public function meditationRetreats()
    {
        return view('frontend.retreats.meditation-retreats');
    }

    public function yogaRetreats()
    {
        return view('frontend.retreats.yoga-retreats');
    }

    public function spiritualRetreats()
    {
        return view('frontend.retreats.spiritual-retreats');
    }

    public function natureRetreats()
    {
        return view('frontend.retreats.nature-retreats');
    }

    public function couplesRetreats()
    {
        return view('frontend.retreats.couples-retreats');
    }

    public function fitnessRetreats()
    {
        return view('frontend.retreats.fitness-retreats');
    }

    public function digitalDetoxRetreats()
    {
        return view('frontend.retreats.digital-detox-retreats');
    }

    public function weightLossRetreats()
    {
        return view('frontend.retreats.weight-loss-retreats');
    }

    public function detoxRetreats()
    {
        return view('frontend.retreats.detox-retreats');
    }

    public function spaRetreats()
    {
        return view('frontend.retreats.spa-retreats');
    }

    // ─── Contact Form ─────────────────────────────────────────────────────────

    public function contact(Request $request)
    {
        $recaptchaEnabled = (bool) config('services.recaptcha.enabled');

        $validated = $request->validate([
            'fname'        => 'required|string|max:100',
            'lname'        => 'required|string|max:100',
            'email'        => 'required|email|max:200',
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-().\s]+$/'],
            'message'      => 'required|string|max:2000',
            'reason'       => 'nullable|string|max:500',
            'g-recaptcha-response' => $recaptchaEnabled ? 'required|string' : 'nullable|string',
        ]);

        if ($recaptchaEnabled) {
            $recaptchaSecret = config('services.recaptcha.secret');

            if (empty($recaptchaSecret)) {
                Log::warning('reCAPTCHA is enabled but RECAPTCHA_SECRET_KEY is missing.');

                return back()
                    ->withErrors(['captcha' => 'Captcha configuration is incomplete. Please try again later.'])
                    ->withInput();
            }

            try {
                $captchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => $recaptchaSecret,
                    'response' => $request->input('g-recaptcha-response'),
                    'remoteip' => $request->ip(),
                ]);

                $captchaBody = $captchaResponse->json();
                $captchaOk   = (bool) ($captchaBody['success'] ?? false);

                if (!$captchaOk) {
                    return back()
                        ->withErrors(['captcha' => 'Captcha verification failed. Please try again.'])
                        ->withInput();
                }
            } catch (\Exception $e) {
                Log::error('Error verifying reCAPTCHA: ', [
                    'error' => $e->getMessage(),
                    'line'  => $e->getLine(),
                ]);

                return back()
                    ->withErrors(['captcha' => 'Unable to verify captcha at the moment. Please try again.'])
                    ->withInput();
            }
        }

        // Save message for admin panel.
        try {
            ContactMessage::create([
                'fname'        => $validated['fname'],
                'lname'        => $validated['lname'],
                'email'        => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'reason'       => $validated['reason'] ?? null,
                'message'      => $validated['message'],
                'ip_address'   => $request->ip(),
                'user_agent'   => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving contact message: ', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Send email notification to the property owner
        // try {
        // AlexLluch3@gmail.com
        $email = 'AlexLluch3@gmail.com';
            Mail::to($email)->send(new ContactFormMail($validated));
        // } catch (\Exception $e) {
        //     Log::error('Error sending contact email: ', [
        //         'error' => $e->getMessage(),
        //         'line' => $e->getLine(),
        //         'trace' => $e->getTraceAsString(),
        //     ]);
        // }

        return back()->with('success', 'Thank you! Your message has been sent.');
    }
}
