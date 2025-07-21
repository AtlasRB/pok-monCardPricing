<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Items List</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>

    <body style="color: white; background-color: black;">
        <div class="container mt-5">
            <h2>Cards List</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div style="margin-bottom: 15px;">
                <a href="{{ route('cards.index', ['sort' => $sortBy, 'direction' => $direction]) }}" 
                class="btn {{ is_null(request('type')) ? 'btn-primary' : 'btn-secondary' }}" style="margin-bottom: 15px">
                All
                </a>
                
                @foreach($types as $cardType)
                    <a href="{{ route('cards.index', ['type' => $cardType, 'sort' => $sortBy, 'direction' => $direction]) }}" 
                    class="btn {{ request('type') == $cardType ? 'btn-primary' : 'btn-secondary' }}" style="margin-bottom: 15px">
                        {{ $cardType }}
                    </a>
                @endforeach
            </div>

            <table class="table table-bordered" style="border-color: black; text-align: center; vertical-align: middle;">
                <thead>
                    <tr>
                        <th style="width: 25%;">
                            <a href="{{ route('cards.index', ['sort' => 'name', 'direction' => $sortBy === 'name' && $direction === 'asc' ? 'desc' : 'asc', 'type' => request('type')]) }}" style="color: black; text-decoration: none;">
                                Name
                                @if($sortBy === 'name')
                                    {!! $direction === 'asc' ? '🔼' : '🔽' !!}
                                @endif
                            </a>
                        </th>
                        <th style="width: 15%;">
                            <a href="{{ route('cards.index', ['sort' => 'number', 'direction' => $sortBy === 'number' && $direction === 'asc' ? 'desc' : 'asc', 'type' => request('type')]) }}" style="color: black; text-decoration: none;">
                                Number
                                @if($sortBy === 'number')
                                    {!! $direction === 'asc' ? '🔼' : '🔽' !!}
                                @endif
                            </a>
                        </th>
                        <th style="width: 15%;">
                            <a href="{{ route('cards.index', ['sort' => 'price', 'direction' => $sortBy === 'price' && $direction === 'asc' ? 'desc' : 'asc', 'type' => request('type')]) }}" style="color: black; text-decoration: none;">
                                Price
                                @if($sortBy === 'price')
                                    {!! $direction === 'asc' ? '🔼' : '🔽' !!}
                                @endif
                            </a>
                        </th>
                        <th style="width: 15%;">Link</th>
                        <th style="width: 15%;">Type</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cards as $card)
                    <tr>
                        <td>{{ $card->name }}</td>
                        <td>{{ $card->number }}</td>
                        <td style="{{ $card->sold ? 'color: white; background-color:rgb(255, 0, 0);' : '' }};">£{{ number_format($card->price, 2) }}    
                            @if($card->sold)
                                <br>
                                Sold for: £{{ number_format($card->soldPrice, 2) }}
                            @endif</td>
                        <td><a href="{{ $card->link }}" target="_blank">View</a></td>
                        <td>{{ $card->type }}</td>
                        <td>
                            <a href="{{ route('cards.edit', $card->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('cards.destroy', $card->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <h3>Stats</h3>
            <p>Total Cards: {{ $totalCards }}</p>
            <p>Total Price: £{{ number_format($totalPrice, 2) }}</p>
            <p>Average Price Per Card: £{{ number_format($averagePrice, 2) }}</p>

            <h3>Add New Item</h3>
            @php
                $cardTypes = ['Gen 1 - Not selling', 'Gen 1 - Double', 'Gen 2 - Not selling', 'Gen 2 - Double', 'Gen 3 - Not selling', 'Gen 3 - Double', 'Gen 4 - Not selling', 'Gen 4 - Double', 'Gen 5 - Not selling', 'Gen 5 - Double', 'Gen 6 - Not selling', 'Gen 6 - Double', 'Items - Not selling', 'Items - Double'];
            @endphp
            <form action="{{ route('cards.store') }}" method="POST" class="mb-5">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="number" class="form-control" placeholder="Number" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="price" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="col-md-3 mb-4">
                        <input type="url" name="link" class="form-control" placeholder="Link" required>
                    </div>
                    <select class="col-md-3" name="type" required>
                        @foreach($cardTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">Add Item</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
