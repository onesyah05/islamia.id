@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('description', 'Halaman dashboard aplikasi')

@section('content')

@if($isAdmin)
<!-- Admin Dashboard -->
<div class="row g-4">
  <!-- Welcome Card -->
  <div class="col-12">
    <div class="card bg-primary text-white">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-white">Assalamu'alaikum! 🎉</h5>
            <p class="mb-4">
              Selamat datang di dashboard admin aplikasi tanya jawab Islam.
            </p>
            <a href="#" class="btn btn-sm btn-light">Lihat Profil</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('admin/img/illustrations/man-with-laptop-light.png') }}"
              height="140"
              alt="View Badge User"
              data-app-dark-img="illustrations/man-with-laptop-dark.png"
              data-app-light-img="illustrations/man-with-laptop-light.png"
            />
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="card-title d-flex align-items-center">
            <div class="avatar flex-shrink-0 me-2">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="bx bx-user"></i>
              </span>
            </div>
            <div>
              <span class="fw-semibold d-block mb-1">Total User</span>
              <h3 class="card-title mb-2">{{ $totalUsers }}</h3>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <small class="text-success fw-semibold"><i class="bx bx-user"></i> +{{ $totalUstadz }} Ustadz</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-md-6 col-lg-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="card-title d-flex align-items-center">
            <div class="avatar flex-shrink-0 me-2">
              <span class="avatar-initial rounded bg-label-warning">
                <i class="bx bx-question-mark"></i>
              </span>
            </div>
            <div>
              <span class="fw-semibold d-block mb-1">Total Pertanyaan</span>
              <h3 class="card-title mb-2">{{ $totalQuestions }}</h3>
            </div>
          </div>
        </div>
        <div class="mt-3">
          <small class="text-warning fw-semibold"><i class="bx bx-time"></i> {{ $unansweredQuestions }} Belum Dijawab</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-md-6 col-lg-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="card-title d-flex align-items-center">
            <div class="avatar flex-shrink-0 me-2">
              <span class="avatar-initial rounded bg-label-info">
                <i class="bx bx-bookmark"></i>
              </span>
            </div>
            <div>
              <span class="fw-semibold d-block mb-1">Total Bookmark</span>
              <h3 class="card-title mb-2">{{ $totalBookmarks }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-md-6 col-lg-3">
    <div class="card h-100">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="card-title d-flex align-items-center">
            <div class="avatar flex-shrink-0 me-2">
              <span class="avatar-initial rounded bg-label-success">
                <i class="bx bx-check-circle"></i>
              </span>
            </div>
            <div>
              <span class="fw-semibold d-block mb-1">Total Jawaban</span>
              <h3 class="card-title mb-2">{{ $totalAnswers }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="col-12 col-lg-8">
    <div class="card h-100">
      <div class="row row-bordered g-0">
        <div class="col-md-8">
          <h5 class="card-header m-0 me-2 pb-3">Statistik Pertanyaan Bulanan</h5>
          <div style="position: relative; height: 350px;">
            <canvas id="monthlyQuestionsChart"></canvas>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-body">
            <h5 class="card-title">Top Kategori</h5>
            <ul class="list-unstyled">
              @foreach($topCategories as $category)
              <li class="d-flex justify-content-between mb-2">
                <span>{{ $category->name }}</span>
                <span class="badge bg-label-primary">{{ $category->questions_count }}</span>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Questions -->
  <div class="col-12 col-lg-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Pertanyaan Terbaru</h5>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
            <a class="dropdown-item" href="">Semua Pertanyaan</a>
            <a class="dropdown-item" href="">Belum Dijawab</a>
            <a class="dropdown-item" href="">Sudah Dijawab</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          @foreach($recentQuestions as $question)
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-{{ $question->answers->count() > 0 ? 'success' : 'primary' }}">
                <i class="bx bx-user"></i>
              </span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <small class="text-muted d-block mb-1">{{ $question->user->name }}</small>
                <h6 class="mb-0">{{ Str::limit($question->title, 50) }}</h6>
                <small class="text-muted">{{ $question->categories->first()->name ?? 'Uncategorized' }}</small>
              </div>
              <div class="user-progress">
                <span class="badge bg-label-{{ $question->answers->count() > 0 ? 'success' : 'warning' }}">
                  {{ $question->answers->count() > 0 ? 'Sudah Dijawab' : 'Belum Dijawab' }}
                </span>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  <!-- Top Ustadz -->
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Top Ustadz</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Total Jawaban</th>
                <th>Total Pertanyaan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topUstadz as $ustadz)
              <tr>
                <td>{{ $ustadz->name }}</td>
                <td>{{ $ustadz->answers_count }}</td>
                <td>{{ $ustadz->questions_count }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

@if($isUstadz)
<!-- Ustadz Dashboard -->
<div class="row">
  <!-- Welcome Card -->
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-success">Assalamu'alaikum Ustadz! 🎉</h5>
            <p class="mb-4">
              Selamat datang di dashboard ustadz. Mari bantu menjawab pertanyaan dari jamaah.
            </p>
            <a href="{{ route('ustadz.profile') }}" class="btn btn-sm btn-outline-success">Lihat Profil</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('admin/img/illustrations/man-with-laptop-light.png') }}"
              height="140"
              alt="View Badge User"
              data-app-dark-img="illustrations/man-with-laptop-dark.png"
              data-app-light-img="illustrations/man-with-laptop-light.png"
            />
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="col-lg-4 col-md-4 order-1">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{ asset('admin/img/icons/unicons/question.png') }}" alt="questions" class="rounded" />
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Pertanyaan Dijawab</span>
            <h3 class="card-title mb-2">{{ $ustadzStats['total_questions_answered'] }}</h3>
            <small class="text-warning fw-semibold"><i class="bx bx-time"></i> {{ $unansweredQuestions }} Menunggu</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{ asset('admin/img/icons/unicons/answer.png') }}" alt="answers" class="rounded" />
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Total Jawaban Diberikan</span>
            <h3 class="card-title mb-2">{{ $ustadzStats['total_answers'] }}</h3>
            <small class="text-success fw-semibold"><i class="bx bx-check"></i> Selesai</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Answers -->
  <div class="col-12 col-lg-8 order-2">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Jawaban Terbaru Diberikan</h5>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          @foreach($ustadzStats['recent_answers'] as $answer)
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="bx bx-user"></i>
              </span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <small class="text-muted d-block mb-1">Pertanyaan dari {{ $answer->question->user->name }}</small>
                <h6 class="mb-0">{{ Str::limit($answer->question->title, 50) }}</h6>
                <small class="text-muted">Dijawab {{ $answer->created_at->diffForHumans() }}</small>
              </div>
              <div class="user-progress">
                {{-- Rating removed --}}
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  <!-- Questions to Answer -->
  <div class="col-12 col-lg-4 order-3">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Pertanyaan yang Perlu Dijawab</h5>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
            <a class="dropdown-item" href="{{ route('ustadz.questions.index') }}">Semua Pertanyaan</a>
            <a class="dropdown-item" href="{{ route('ustadz.questions.index', ['status' => 'unanswered']) }}">Belum Dijawab</a>
            <a class="dropdown-item" href="{{ route('ustadz.questions.index', ['status' => 'answered']) }}">Sudah Dijawab</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          @foreach($recentQuestions as $question)
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="bx bx-user"></i>
              </span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <small class="text-muted d-block mb-1">{{ $question->user->name }}</small>
                <h6 class="mb-0">{{ Str::limit($question->title, 50) }}</h6>
                <small class="text-muted">{{ $question->created_at->diffForHumans() }}</small>
              </div>
              <div class="user-progress">
                <a href="{{ route('ustadz.questions.show', $question->id) }}" class="btn btn-sm btn-primary">Jawab</a>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endif

@endsection

@push('scripts')
<script>
  // Monthly Questions Chart
  const monthlyQuestionsData = @json($monthlyQuestions);
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  const questionsData = months.map((_, index) => {
    const monthData = monthlyQuestionsData.find(m => m.month == index + 1);
    return monthData ? monthData.total : 0;
  });

  const ctx = document.getElementById('monthlyQuestionsChart').getContext('2d');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label: 'Total Pertanyaan',
        data: questionsData,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 2,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          display: true
        }
      },
      tension: 0.3
    }
  });
</script>

@endpush