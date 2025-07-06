<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class HeroSection extends Component
{
    public $title;
    public $subtitle;
    public $backgroundImage;
    public $ctaText;
    public $ctaLink;
    public $secondaryCtaText;
    public $secondaryCtaLink;
    public $features;
    public $badgeText;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = 'Exclusive Real Estate Auctions',
        $subtitle = 'Bid on premium properties at Sahil e Firdaus. Invitation-only. Transparent. Secure. Fast.',
        $backgroundImage = 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80',
        $ctaText = 'View Auctions',
        $ctaLink = '#auctions',
        $secondaryCtaText = 'Get Invitation',
        $secondaryCtaLink = '#register',
        $features = [],
        $badgeText = '🏆 Premium Real Estate'
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->backgroundImage = $backgroundImage;
        $this->ctaText = $ctaText;
        $this->ctaLink = $ctaLink;
        $this->secondaryCtaText = $secondaryCtaText;
        $this->secondaryCtaLink = $secondaryCtaLink;
        $this->features = $features;
        $this->badgeText = $badgeText;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.hero-section');
    }
} 