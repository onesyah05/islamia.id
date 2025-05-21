@extends('admin.layouts.app')

@section('title', 'Edit Question')
@section('description', 'Edit an existing question')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Question</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.questions.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $question->title) }}" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Question Content</label>
                <textarea class="form-control" id="content" name="content" rows="4" required>{{ old('content', $question->content) }}</textarea>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="answer_content" class="form-label">Answer</label>
                <textarea class="form-control" id="answer_content" name="answer_content" rows="6">{{ old('answer_content', $question->answers->first()->content ?? '') }}</textarea>
                @error('answer_content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">Categories</label>
                <div class="category-input-container">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control category-input" placeholder="Search or add new category">
                        <button type="button" class="btn btn-success add-category">Add</button>
                    </div>
                    <div class="category-suggestions list-group" style="position: absolute; z-index: 1000; width: calc(100% - 16px); max-height: 150px; overflow-y: auto; display: none;"></div>
                    <div class="category-tags">
                        @foreach($question->categories as $category)
                            <div class="category-tag" style="background-color: {{ '#' . substr(md5($category->name), 0, 6) }}; color: #fff;">
                                {{ $category->name }}
                                <span class="remove-category" data-id="{{ $category->id }}">×</span>
                            </div>
                        @endforeach
                    </div>
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
                        <option value="{{ $ustadz->id }}" {{ old('ustadz_id', $question->answers->first()->user_id ?? '') == $ustadz->id ? 'selected' : '' }}>{{ $ustadz->name }}</option>
                    @endforeach
                </select>
                @error('ustadz_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @endif

            <button type="submit" class="btn btn-primary">Update Question</button>
            <a href="{{ route('dashboard.questions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@push('styles')
<style>
.category-input-container {
    position: relative;
}

.category-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}

.category-tag {
    padding: 8px 12px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.category-tag:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.category-tag .remove-category {
    cursor: pointer;
    color: inherit;
    opacity: 0.8;
    font-weight: bold;
    font-size: 16px;
    display: flex;
    align-items: center;
    transition: opacity 0.2s ease;
}

.category-tag .remove-category:hover {
    opacity: 1;
}

.category-suggestions {
    position: absolute;
    z-index: 1000;
    width: calc(100% - 16px);
    max-height: 200px;
    overflow-y: auto;
    display: none;
    border: 1px solid #ddd;
    background: #fff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border-radius: 8px;
    top: 100%;
    left: 8px;
    margin-top: 4px;
}

.category-suggestions .list-group-item {
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s ease;
}

.category-suggestions .list-group-item:hover {
    background-color: #f8f9fa;
}

.category-input-container .input-group {
    border-radius: 8px;
    overflow: hidden;
}

.category-input-container .input-group .form-control {
    border: 1px solid #ddd;
    border-right: none;
    padding: 10px 15px;
}

.category-input-container .input-group .form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.category-input-container .input-group .btn {
    padding: 10px 20px;
    font-weight: 500;
}

.category-input-container .form-control::placeholder {
    color: #999;
    font-style: normal;
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

    // Initialize CKEditor for answer content
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
    let selectedCategories = new Map();
    const availableCategories = @json($categories);

    // Initialize selected categories from existing tags
    document.querySelectorAll('.category-tag').forEach(tag => {
        const id = parseInt(tag.querySelector('.remove-category').getAttribute('data-id'));
        const name = tag.textContent.trim();
        selectedCategories.set(id, name);
    });

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