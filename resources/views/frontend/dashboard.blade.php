<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(90deg, #0066ff, #00ccff);
            color: white;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }
        .card {
            border: none;
            border-radius: 12px;
        }
        .card-header {
            background: linear-gradient(90deg, #00ccff, #0066ff);
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 12px;
        }
        .rounded-circle {
            border: 2px solid #0066ff;
        }
        .btn-primary {
            background-color: #0066ff;
            border-color: #0066ff;
        }
        .btn-outline-primary {
            color: #0066ff;
            border-color: #0066ff;
        }
        .btn-outline-primary:hover {
            background-color: #0066ff;
            color: white;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark shadow py-3">
        <div class="container">
            <a class="navbar-brand">HisBinary</a>
        </div>
    </nav>
</header>

<!-- Main Content -->
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <!-- Add Question Button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                Add Question
            </button>
        </div>
    </div>

    <!-- Posts Section -->
    <div id="questionSection">
        @foreach ($posts as $post)
        <!-- Post Card -->
        <div class="card mb-4 shadow">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="https://via.placeholder.com/50" class="rounded-circle" alt="User Avatar">
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $post->user->name }}</h6>
                        <small class="text-light">Posted just now</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p class="mb-3">{{ $post->question_text }}</p>

                <!-- Comments Section -->
                <div class="bg-light p-3 rounded">
                    <h6>Comments</h6>
                    @if ($post->comments && $post->comments->count() > 0)
                        @foreach ($post->comments as $comment)
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/40" class="rounded-circle" alt="User Avatar">
                            </div>
                            <div>
                                <p class="mb-1"><strong>{{ $comment->user->name }}</strong> {{ $comment->comment_text }}</p>
                                <small class="text-muted">A moment ago</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">No comments yet. Be the first to comment!</p>
                    @endif
                </div>

                <!-- Add Comment Button -->
                <button
                    type="button"
                    class="btn btn-sm btn-outline-primary mt-3"
                    data-bs-toggle="modal"
                    data-bs-target="#commentModal-{{ $post->id }}">
                    Add Comment
                </button>
            </div>
        </div>

        <!-- Comment Modal -->
        <div class="modal fade" id="commentModal-{{ $post->id }}" tabindex="-1" aria-labelledby="commentModalLabel-{{ $post->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentModalLabel-{{ $post->id }}">Add a Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('comment.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="mb-3">
                                <label for="commentText-{{ $post->id }}" class="form-label">Comment</label>
                                <textarea class="form-control" name="comment_text" id="commentText-{{ $post->id }}" rows="3" placeholder="Write your comment..." required></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuestionModalLabel">Add a New Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('post.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="questionText" class="form-label">What’s on Your Mind?</label>
                        <textarea class="form-control" name="question_text" id="questionText" rows="3" placeholder="Enter your question" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
