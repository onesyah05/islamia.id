@extends('admin.layouts.app')

@section('title', 'Create Question')
@section('description', 'Create a new question')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create Question</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.questions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Question Content</label>
                <textarea class="form-control" id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="answer_content" class="form-label">Answer</label>
                <textarea class="form-control" id="answer_content" name="answer_content" rows="6">{{ old('answer_content') }}</textarea>
                @error('answer_content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">Categories</label>
                <div class="category-input-container">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control category-input" placeholder="Enter category">
                        <button type="button" class="btn btn-success add-category">Add</button>
                    </div>
                    <div class="category-suggestions list-group" style="position: absolute; z-index: 1000; width: calc(100% - 16px); max-height: 150px; overflow-y: auto; display: none;"></div>
                    <div class="category-tags"></div>
                    <input type="hidden" name="category_ids[]" id="category_ids">
                </div>
                @error('category_ids')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            @if(auth()->user()->role === 'admin')
            <div class="mb-3">
                <label for="ustadz_id" class="form-label">Assign Ustadz</label>
                <select class="form-control" id="ustadz_id" name="ustadz_id">
                    <option value="">Select Ustadz (Optional)</option>
                    @foreach($ustadzList as $ustadz)
                        <option value="{{ $ustadz->id }}" {{ old('ustadz_id') == $ustadz->id ? 'selected' : '' }}>{{ $ustadz->name }}</option>
                    @endforeach
                </select>
                @error('ustadz_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @endif

            <button type="submit" class="btn btn-primary">Create Question</button>
            <a href="{{ route('dashboard.questions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@push('styles')
<style>
/* Container is now primarily for positioning suggestions */
.category-input-container {
    position: relative;
    /* Styles for the input group and tags will be handled separately */
}

.category-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px; /* Space below the input group */
}

.category-tag {
    /* background: #e9ecef; Remove fixed background */
    padding: 10px; /* Adjusted padding */
    border-radius: 20px; /* Make corners more rounded */
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 14px;
    color: #333;
}

.category-tag .remove-category {
    cursor: pointer;
    color: #dc3545; /* Red color for remove */
    font-weight: bold; /* Make 'x' bold */
    font-size: 14px; /* Adjust size */
    display: flex;
    align-items: center;
}

/* Style for the suggestions dropdown */
.category-suggestions {
    position: absolute;
    z-index: 1000;
    width: calc(100% - 16px); /* Match the width of the input group, considering padding */
    max-height: 150px;
    overflow-y: auto;
    display: none;
    border: 1px solid #ccc; /* Border */
    background: #fff; /* White background */
    box-shadow: 0 2px 5px rgba(0,0,0,0.2); /* Shadow */
    border-radius: 4px; /* Rounded corners */
    top: 100%; /* Position directly below the input group */
    left: 8px; /* Align with input group padding */
    margin-top: 2px; /* Small gap below input group */
}

.category-suggestions .list-group-item {
    border: none; /* Remove individual item borders */
    padding: 8px 15px; /* Padding */
    cursor: pointer;
    font-size: 14px; /* Adjust font size */
}

.category-suggestions .list-group-item:hover {
    background-color: #f8f9fa; /* Light hover background */
}

/* Adjust Bootstrap input-group and button styles */
.category-input-container .input-group {
    border-radius: 4px; /* Match the dropdown border-radius */
    overflow: hidden; /* Ensure button and input corners are rounded together */
}

.category-input-container .input-group .form-control {
    border: 1px solid #ccc; /* Add border to input */
    border-right: none; /* Remove right border to blend with button */
    box-shadow: none; /* Remove default focus shadow */
}

.category-input-container .input-group .form-control:focus {
    border-color: #80bdff; /* Bootstrap focus blue */
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Bootstrap focus shadow */
}

.category-input-container .input-group .btn {
    /* Default Bootstrap button styling should work well */
}

/* Placeholder styling */
.category-input-container .form-control::placeholder {
    color: #aaa; /* Light grey color */
    font-style: normal; /* Remove italic */
}

</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize CKEditor for content
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });

    // Initialize CKEditor for answer content (optional for create page)
    ClassicEditor
        .create(document.querySelector('#answer_content'))
        .catch(error => {
            console.error(error);
        });

    // Category handling
    const categoryInput = document.querySelector('.category-input');
    const addCategoryBtn = document.querySelector('.add-category');
    const categoryTags = document.querySelector('.category-tags');
    const categoryIdsInput = document.querySelector('#category_ids');
    const categorySuggestionsContainer = document.querySelector('.category-suggestions');
    let selectedCategories = new Map(); // Use Map to store id => name
    const availableCategories = @json($categories);

    // Load existing categories (only applicable for edit, so no loop here)

    // Show suggestions on input
    categoryInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        categorySuggestionsContainer.innerHTML = '';

        if (query.length > 0) {
            const filteredCategories = availableCategories.filter(category =>
                category.name.toLowerCase().includes(query) && !selectedCategories.has(category.id)
            );

            if (filteredCategories.length > 0) {
                filteredCategories.forEach(category => {
                    const suggestionItem = document.createElement('button');
                    suggestionItem.type = 'button';
                    suggestionItem.className = 'list-group-item list-group-item-action';
                    suggestionItem.textContent = category.name;
                    suggestionItem.setAttribute('data-id', category.id);
                    suggestionItem.setAttribute('data-name', category.name);

                    suggestionItem.addEventListener('click', function() {
                        const id = parseInt(this.getAttribute('data-id'));
                        const name = this.getAttribute('data-name');
                        addCategoryTag(id, name);
                        categoryInput.value = '';
                        categorySuggestionsContainer.style.display = 'none';
                    });

                    categorySuggestionsContainer.appendChild(suggestionItem);
                });
                categorySuggestionsContainer.style.display = 'block';
            } else {
                categorySuggestionsContainer.style.display = 'none';
            }
        } else {
            categorySuggestionsContainer.style.display = 'none';
        }
    });

    // Hide suggestions when input loses focus (with a slight delay)
    categoryInput.addEventListener('blur', function() {
        setTimeout(() => {
            categorySuggestionsContainer.style.display = 'none';
        }, 100);
    });

    // Show suggestions when input gains focus if there's text
    categoryInput.addEventListener('focus', function() {
        const query = this.value.trim().toLowerCase();
        if (query.length > 0 && categorySuggestionsContainer.children.length > 0) {
            categorySuggestionsContainer.style.display = 'block';
        }
    });

    addCategoryBtn.addEventListener('click', function() {
        const categoryName = categoryInput.value.trim();
        if (categoryName) {
            const foundCategory = availableCategories.find(cat => cat.name.toLowerCase() === categoryName.toLowerCase());

            if (foundCategory) {
                addCategoryTag(foundCategory.id, foundCategory.name);
            } else {
                alert('Category ' + categoryName + ' not found. Please select from existing categories or add in category management section.');
            }
            categoryInput.value = '';
            categorySuggestionsContainer.style.display = 'none';
        }
    });

    // Allow adding category by pressing Enter in the input field
    categoryInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            if (categorySuggestionsContainer.style.display === 'block' && categorySuggestionsContainer.children.length > 0) {
                categorySuggestionsContainer.children[0].click();
            } else {
                addCategoryBtn.click();
            }
        }
    });

    function addCategoryTag(id, name) {
        if (selectedCategories.has(id)) return; // Prevent duplicates

        selectedCategories.set(id, name);

        const tag = document.createElement('div');
        tag.className = 'category-tag';
        // Generate and apply random background color
        const randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
        tag.style.backgroundColor = randomColor;
        // Optionally, adjust text color based on background for readability
        const luminance = 0.299 * parseInt(randomColor.substring(1, 3), 16) + 0.587 * parseInt(randomColor.substring(3, 5), 16) + 0.114 * parseInt(randomColor.substring(5, 7), 16);
        tag.style.color = luminance > 128 ? '#333' : '#fff'; // Use dark text for light backgrounds, white for dark

        tag.innerHTML = `
            ${name}
            <span class="remove-category" data-id="${id}">×</span>
        `;

        tag.querySelector('.remove-category').addEventListener('click', function() {
            const removeId = parseInt(this.getAttribute('data-id'));
            selectedCategories.delete(removeId);
            tag.remove();
            updateCategoryIds();
        });

        categoryTags.appendChild(tag);
        updateCategoryIds();
    }

    function updateCategoryIds() {
        // Remove all existing category_id inputs except the main one
        document.querySelectorAll('input[name="category_ids[]"]').forEach(input => {
            if (input !== categoryIdsInput) {
                input.remove();
            }
        });

        // Add new inputs for each selected category
        selectedCategories.forEach((name, id) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'category_ids[]';
            input.value = id;
            categoryIdsInput.parentNode.appendChild(input);
        });
    }
});
</script>
@endpush
@endsection 