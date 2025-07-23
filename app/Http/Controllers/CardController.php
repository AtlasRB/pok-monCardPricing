<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;

class CardController extends Controller
{
    //
    public function index(Request $request)
    {
        $sortBy = $request->query('sort', 'name');
        $direction = $request->query('direction', 'asc');
        $selectedType = $request->query('type');

        $allowedSorts = ['name', 'price', 'number'];
        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }

        if (!in_array($direction, $allowedDirections)) {
            $direction = 'asc';
        }

        $query = Card::orderBy($sortBy, $direction);
        if ($selectedType) {
            $query->where('type', $selectedType);
        }

        $cards = $query->get();

        $totalCards = $cards->count();
        $soldCount = $cards->where('sold', true)->count();
        $unsoldCount = $cards->where('sold', false)->count();

        $totalPrice = $cards->sum('price');    
        $soldPrice = $cards->where('sold', true)->sum('soldPrice');
        $unsoldPrice = $cards->where('sold', false)->sum('price');

        $averagePrice = $totalCards > 0 ? $totalPrice / $totalCards : 0;
        $averageSoldPrice = $soldCount > 0 ? $soldPrice / $soldCount : 0;
        $averageUnsoldPrice = $unsoldCount > 0 ? $unsoldPrice / $unsoldCount : 0;

        $types = Card::select('type')->distinct()->pluck('type');

        return view('cards.index', compact('cards', 'sortBy', 'direction', 'totalCards', 'totalPrice', 'averagePrice', 'selectedType', 'types', 'soldCount', 'unsoldCount', 'soldPrice', 'unsoldPrice', 'averageSoldPrice', 'averageUnsoldPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer',
            'price' => 'required|numeric',
            'link' => 'required|url',
            'type' => 'required|string',
            'sold' => 'sometimes|boolean',
            'soldPrice' => 'nullable|numeric'
        ]);

        Card::create($request->all());

        return redirect()->route('cards.index', [
            'type' => $request->input('type')
        ])->with('success', 'Card created successfully!');
    }

    public function edit(Card $card)
    {
        return view('cards.edit', compact('card'));
    }

    public function update(Request $request, Card $card)
    {
        $card->update([
            'name' => $request->name,
            'number' => $request->number,
            'price' => $request->price,
            'link' => $request->link,
            'type' => $request->type,
            'sold' => $request->has('sold'),
            'soldPrice' => $request->soldPrice,
        ]);

        return redirect()->route('cards.index')->with('success', 'Card updated successfully!');
    }

    public function destroy(Card $card)
    {
        $card->delete();

        return redirect()->route('cards.index')->with('success', 'Card deleted successfully!');
    }
}
