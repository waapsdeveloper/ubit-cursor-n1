<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Auction;

class FeaturedProperties extends Component
{
    public $properties;
    public $title;
    public $subtitle;
    public $showViewAll;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = 'Featured Properties in Auction',
        $subtitle = 'Discover exclusive properties available for bidding',
        $showViewAll = true,
        $limit = 6
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->showViewAll = $showViewAll;
        
        // Get featured properties from database
        $this->properties = Auction::where('status', 'active')
            ->latest('start_time')
            ->take($limit)
            ->get();
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.featured-properties');
    }
} 