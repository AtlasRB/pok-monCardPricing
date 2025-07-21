<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Item</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>

    <body style="background-color: black; color: white;">
        <div class="container mt-5">
            <h2>Edit Card</h2>
            @php
                $cardTypes = ['Gen 1 - Not selling', 'Gen 1 - Double', 'Gen 2 - Not selling', 'Gen 2 - Double', 'Gen 3 - Not selling', 'Gen 3 - Double', 'Gen 4 - Not selling', 'Gen 4 - Double', 'Gen 5 - Not selling', 'Gen 5 - Double', 'Gen 6 - Not selling', 'Gen 6 - Double', 'Items'];
            @endphp
            <form action="{{ route('cards.update', $card->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $card->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Number</label>
                    <input type="number" name="number" class="form-control" value="{{ $card->number }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" value="{{ $card->price }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Link</label>
                    <input type="url" name="link" class="form-control" value="{{ $card->link }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select class="col-md-3 form-control" name="type" required>
                        @foreach($cardTypes as $type)
                            <option value="{{ $type }}" {{ $card->type === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label" for="soldCheckbox">Sold</label>
                    <input type="checkbox" name="sold" class="form-check-input" id="soldCheckbox" {{ $card->sold ? 'checked' : '' }}>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sold price</label>
                    <input type="text" name="soldPrice" class="form-control" value="{{ $card->soldPrice }}" required>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </body>
</html>