@if( $m instanceof \App\Models\Partituravod )
  <a href="{{ route('sistema.alunos.download.partitura', $m->id) }}" class="text-gray btn-material">
    <div class="row padding-10 item vertical-middle">
        <div class="col-lg-6">
            <div class="row vertical-middle quick text-gray text-15-pt semibold">
                <i class="far fa-file-alt padding-right-5"></i>
                {{ $m->arquivo }}
            </div>
        </div>
        <div class="col-lg-1">
            <i class="fas fa-download"></i>
        </div>
    </div>
  </a>
@endif

@if( $m instanceof \App\Models\Backingtrakvod )
  <a href="{{ route('sistema.alunos.download.backtrack', $m->id) }}" class="text-gray btn-material">
    <div class="row padding-10 item vertical-middle">
        <div class="col-lg-6">
            <div class="row vertical-middle quick text-gray text-15-pt semibold">
                <i class="far fa-file-alt padding-right-5"></i>
                {{ $m->arquivo }}
            </div>
        </div>
        <div class="col-lg-1">
            <i class="fas fa-download"></i>
        </div>
    </div>
  </a>
@endif