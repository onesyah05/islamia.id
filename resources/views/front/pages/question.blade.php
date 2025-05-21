@extends('front.layouts.app')

@section('title', 'Ajukan Pertanyaan')

@section('content')

    <div class="container">
        <div class="question-container" style="margin: 10px">
            <!-- Question Input Form -->
            <form id="questionForm" action="{{ route('questions.store') }}" method="POST">
                @csrf
                <textarea class="form-control question-input" name="content" placeholder="Tulis pertanyaan kamu disini" id="questionText"></textarea>
                <button type="submit" class="btn question-button">Ajukan Pertanyaan</button>
            </form>

            <!-- Status Filter -->
            <div class="question-status">
                <div class="question-status-unanswered active">Belum Dijawab</div>
                <div class="question-status-answered">Dijawab</div>
            </div>

            <!-- Unanswered Questions List -->
            <div class="question-list question-list-unanswered">
                @foreach($questions->where('is_answered', false) as $question)
                <div class="question-item">
                    <div class="title-bar-card">
                        {{-- <span class="kiri">{{ $question->categories->first()->name }}</span> --}}
                        <span class="kanan">{{ $question->created_at->format('d F Y') }}</span>
                    </div>
                    <p>{{ $question->content }}</p>
                </div>
                @endforeach
            </div>

            <!-- Answered Questions List -->
            <div class="question-list question-list-answered">
                @foreach($questions->where('is_answered', true) as $question)
                <div class="question-item">
                    <div class="title-bar-card">
                        <span class="kiri">{{ $question->categories->first()->name }}</span>
                        <span class="kanan">{{ $question->created_at->format('d F Y') }}</span>
                    </div>
                    <p>{{ $question->content }}</p>
                    <div class="question-answer">
                        <p>{{ $question->answers->first()->content ?? 'Belum ada jawaban' }}</p>
                    </div>
                    <a href="{{ route('questions.show', $question->slug) }}" class="detail">Selengkapnya</a>
                </div>
                @endforeach
            </div>

            {{ $questions->links() }}
        </div>
        <br>
        <br>
        <br>

        <!-- Bootstrap & jQuery JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                // Toggle between answered and unanswered
                $(".question-status-unanswered").click(function() {
                    $(this).addClass("active");
                    $(".question-status-answered").removeClass("active");
                    $(".question-list-unanswered").show();
                    $(".question-list-answered").hide();
                });

                $(".question-status-answered").click(function() {
                    $(this).addClass("active");
                    $(".question-status-unanswered").removeClass("active");
                    $(".question-list-answered").show();
                    $(".question-list-unanswered").hide();
                });

                // Function to add question click handlers
                function addQuestionClickHandlers() {
                    const questionItems = document.querySelectorAll('.question-item');
                    questionItems.forEach(item => {
                        // Remove old event listeners if any
                        const newItem = item.cloneNode(true);
                        item.parentNode.replaceChild(newItem, item);

                        // Add click event to question item
                        newItem.addEventListener('click', function(e) {
                            // Check if click was on a link
                            if (e.target.tagName === 'A') {
                                // Stop the event from bubbling up to the question-item
                                e.stopPropagation();
                                // Let the default link behavior happen
                                return true;
                            }

                            // If already expanded, collapse it
                            if (this.classList.contains('expanded')) {
                                this.classList.remove('expanded');
                            } else {
                                // First collapse all expanded items
                                questionItems.forEach(qi => {
                                    qi.classList.remove('expanded');
                                });
                                // Then expand this one
                                this.classList.add('expanded');
                            }
                        });
                    });
                }

                // Initialize click handlers
                addQuestionClickHandlers();
            });
        </script>
    </div>

@endsection
