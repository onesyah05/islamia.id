@extends('front.layouts.app')

@section('title', 'Ajukan Pertanyaan')

@section('content')
    <div class="container">
        <div class="question-container" style="margin: 10px">
            <!-- Question Input Form -->
            <form id="questionForm">
                <textarea class="form-control question-input" placeholder="Tulis pertanyaan kamu disini" id="questionText"></textarea>
                <button type="submit" class="btn question-button">Ajukan Pertanyaan</button>
            </form>

            <!-- Status Filter -->
            <div class="question-status">
                <div class="question-status-unanswered active">Belum Dijawab</div>
                <div class="question-status-answered">Dijawab</div>
            </div>

            <!-- Unanswered Questions List -->
            <div class="question-list question-list-unanswered">
                <div class="question-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book?</p>
                </div>
                <div class="question-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book?</p>
                </div>
                <div class="question-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book?</p>
                </div>
            </div>

            <!-- Answered Questions List -->
            <div class="question-list question-list-answered">
                <div class="question-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book?</p>
                    <div class="question-answer">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. This is an answer to
                            the question above.</p>
                    </div>
                </div>
                <div class="question-item">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                        and scrambled it to make a type specimen book?</p>
                    <div class="question-answer">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. This is an answer to
                            the question above. <a
                                href="#">http://islamia.id/detail?question=akupadamukamupadaku_1234</a></p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>

        <!-- Bootstrap & jQuery JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                // Form submission
                $("#questionForm").submit(function(e) {
                    e.preventDefault();
                    const questionText = $("#questionText").val().trim();

                    if (questionText !== "") {
                        // Add new question to the unanswered list
                        $(".question-list-unanswered").prepend(`
                            <div class="question-item">
                                <p>${questionText}</p>
                            </div>
                        `);

                        // Clear the form
                        $("#questionText").val("");

                        // Make sure we're viewing the unanswered questions
                        $(".question-status-unanswered").click();

                        // Add click event to new question item
                        addQuestionClickHandlers();
                    }
                });

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
