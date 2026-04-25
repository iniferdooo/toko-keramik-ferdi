<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ProductIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $size = '';
    public $finish = '';
    public $sortBy = 'latest';

    protected $queryString = [
        'search'   => ['except' => ''],
        'category' => ['except' => ''],
        'size'     => ['except' => ''],
        'finish'   => ['except' => ''],
        'sortBy'   => ['except' => 'latest'],
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategory() { $this->resetPage(); }
    public function updatingSize() { $this->resetPage(); }
    public function updatingFinish() { $this->resetPage(); }

    public function resetFilter()
    {
        $this->search   = '';
        $this->category = '';
        $this->size     = '';
        $this->finish   = '';
        $this->sortBy   = 'latest';
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with('category');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('motif', 'like', '%' . $this->search . '%')
                  ->orWhere('color', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->whereHas('category', fn($q) =>
                $q->where('slug', $this->category)
            );
        }

        if ($this->size) {
            $query->where('size', $this->size);
        }

        if ($this->finish) {
            $query->where('finish', $this->finish);
        }

        match($this->sortBy) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name'       => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12);
        $categories = Category::all();
        $sizes      = Product::distinct()->pluck('size')->sort()->values();

        return view('livewire.product-index', compact('products', 'categories', 'sizes'));
    }
}