@extends('sistema.alunos.layouts.default')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper curso-player">
    <!-- Content Header (Page header) -->
    <div class="content-header padding-left-30">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-gray"><i class="fas fa-chalkboard-teacher"></i>  Meus Cursos</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 horizontal-right">
                    <a href="{{ route('sistema.alunos.meus-cursos') }}" class="btn-purple quick text-13-pt bold">
                        <i class="fas fa-reply padding-right-5"></i>
                        Voltar
                </a>    
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row padding-left-20 xs-padding-0">         
            <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="row title-player">
                                <span>MÓDULO: {{ $modulo->titulo }} </span>
                                <h2>{{ $aula->titulo }}</h2>
                            </div>
                            <div class="row  padding-top-25 page-aulas">
                                <div class="col-6 text-left">
                                    @if($controles['anterior'])
                                        <a href="{{ $controles['anterior'] }}"><i class="fas fa-chevron-circle-left"></i> Aula Anterior</a>
                                    @endif
                                </div>
                                <div class="col-6 text-right">
                                    @if($controles['proximo'])
                                        <a href="{{ $controles['proximo'] }}">Próxima Aula <i class="fas fa-chevron-circle-right"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="row padding-top-10 player-interna relative margin-bottom-100">
                                <video id="vid" controls class="video-js vim-css" height="450" width="1000">
                                </video>
                                <div class="col-12 helper">
                                    <div class="row padding-top-15 padding-right-10 horizontal-right xs-horizontal-left">
                                        <div class="col-lg-4 col-6 horizontal-right">
                                            @if($curso->present()->aulaConcluida($usuario, $modulo, $aula) == 0 )
                                                <button class="btn btn-sm btn-warning quick semibold submit-single-post" data-url="{{ route('sistema.alunos.vod.curso.aula.conclusao', [$curso->slug, $modulo->slug, $aula->slug]) }}" data-texto="Confirma a conclusão desta aula?">
                                                    <i class="fas fa-clipboard-check"></i>
                                                    Marcar aula como concluída
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-success quick semibold">
                                                    <i class="fas fa-check"></i>
                                                    Aula já concluída!
                                                </button>
                                            @endif
                                        </div>
                                        <div class="col-lg-4 col-6 horizontal-right">
                                            @if($aula->present()->preferida($usuario, $modulo) == 0 )
                                                <button class="btn btn-sm btn-primary quick semibold submit-single-post margin-left-10" data-url="{{ route('sistema.alunos.vod.curso.aula.preferida', [$modulo->id, $aula->id]) }}" data-texto="Confirma a inclusão desta aula como preferida?">
                                                    <i class="far fa-star"></i>
                                                    Marcar aula como preferida
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-success quick semibold margin-left-10">
                                                    <i class="fas fa-star"></i>
                                                    Preferida
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row detalhes-player-interno padding-top-20">
                                <ul class="nav nav-tabs interna-player nav-justified" id="myTab" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Descrição</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Partituras e Tablaturas</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Backing Track</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-lg-12 padding-top-15 padding-left-45 padding-right-25 padding-bottom-20 text-14-pt">
                                                {!! $aula->descricao !!}
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        @foreach( $aula->partituras as $partitura )
                                            <img src="{{ $aula->present()->getPartitura($partitura) }}" alt="">
                                        @endforeach
                                    </div>

                                    <div class="tab-pane padding-bottom-30 fade backing-track" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        @if( $aula->backings()->exists() )
                                            @foreach( $aula->backings as $back)
                                                <div class="row margin-top-30 padding-left-50 padding-right-50">
                                                    <div class="col-lg-6">{{ $back->arquivo }}</div>
                                                    {{-- <div class="col-lg-6 text-right"><a href="">Download</a></div> --}}
                                                </div>
                                                <div class="row margin-top-15 padding-left-50 padding-right-50 audio-track">
                                                    <audio controls>
                                                        <source src="{{ $aula->present()->getBack($back) }}" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>


                                </div>
                            </div>

                            <div class="row margin-top-30 padding-15 pergunte-professor margin-bottom-50">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <h2><i class="fas fa-question-circle"></i> Pergunte ao Professor</h2>
                                    </div>

                                    <div class="row padding-top-25 ">
                                        <div class="col-md-1">
                                            <div class="avatar" style="background-image:url('{{ $usuario->imagem ?? assets('sistema/images/default.jpg') }}')"></div>
                                        </div>
                                        <div class="col-md-11">
                                            <form data-action="{{ route('sistema.alunos.pergunta', [$curso->slug, $modulo->slug, $aula->slug]) }}" class="form-normal">
                                                <textarea name="pergunta" placeholder="Digite sua dúvida que ficará pública e responderemos para você"></textarea>
                                                <button type="submit">Perguntar</button>
                                            </form>
                                        </div>
                                    </div>

                                    @forelse( $aula->perguntas->where('status',1) as $pergunta)
                                        <div class="row padding-top-15">
                                            <div class="col-md-1">
                                                <div class="avatar" style="background-image:url('{{ $pergunta->aluno->imagem ?? assets('sistema/images/default.jpg') }}')"></div>
                                            </div>
                                            <div class="col-md-11">
                                                <div class="row nome-data">
                                                    <p>
                                                        <b>{{ $pergunta->aluno->nome }}</b>  {{ $pergunta->created_at->diffForHumans() }} 
                                                    </p>
                                                </div>
                                                <div class="row margin-top-10 duvida">
                                                    <p>{{ $pergunta->pergunta }}</p>
                                                </div>
                                                <div class="row padding-top-20 padding-left-20 resposta margin-bottom-5 vertical-middle">
                                                    <div class="col-lg-1">
                                                        <div class="avatar" style="background-image:url('{{ assets('sistema/alunos/dist/img/avatar-gui.png') }}')"></div>
                                                    </div>
                                                    <div class="col-lg-11">
                                                        <h6 class="bold">Resposta Guitarpedia - {{ $pergunta->updated_at->diffForHumans() }} </h6>
                                                    </div>
                                                </div>
                                                <div class="row padding-left-20">
                                                    <div class="col-lg-1"></div>
                                                    <div class="col-lg-11">
                                                        {!! $pergunta->resposta !!}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-5 padding-left-40 xs-padding-0">
                            <div class="row">
                                <div class="col-lg-12">
                                <ul class="nav nav-tabs interna-player nav-justified" id="myTab" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#aula" role="tab" aria-controls="home" aria-selected="true">Aulas</a>
                                    </li>
                                </ul>
                                <div class="tab-content padding-top-20 panel-modulos-player padding-bottom-50" id="myTabContent">
                                    <div class="tab-pane fade show active" id="aula" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row modulos-curso">

                                        <div class="row">
                                            <div class="col-lg-12 padding-left-10">
                                            <h2>{{ $curso->titulo }}</h2>
                                            <p>por Professor {{ $curso->professor->nome }}</p>
                                            </div>
                                        </div>

                                            <div id="accordion" class="interna-modulos"> 
                                                @foreach( $curso->modulos as $m )
                                                    <h5 class="padding-left-20 padding-right-20">
                                                        <a data-toggle="collapse" href="#modulo_{{ $m->id }}">
                                                            {{ $m->titulo }}
                                                        </a>
                                                    </h5>                
                                                    <div id="modulo_{{ $m->id }}" class="collapse @if( $modulo->id == $m->id) show @endif" data-parent="#accordion">
                                                        <div class="row flex-column padding-left-35 padding-right-35">
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: {{ $m->present()->concluido($usuario) }}%"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row padding-left-55 quick text-gray text-13-pt bold">
                                                            {{ $m->present()->concluido($usuario) }}% Assistidos
                                                        </div>
                                                        <ul class="margin-top-10 margin-bottom-30 lista-aulas">
                                                            @foreach($m->aulas as $a)
                                                                <li class="@if( $modulo->id == $m->id && $aula->id == $a->id) active @endif">
                                                                    <div class="row vertical-middle">
                                                                        <div class="col-md-8">
                                                                            <div class="row">
                                                                                <a href="{{ route('sistema.alunos.vod.curso.player', [$curso->slug, $m->slug, $a->slug]) }}"> <i class="fas fa-play-circle padding-right-10"></i>{{ $a->titulo }}</a>
                                                                            </div>
                                                                        </div>
                                                                        @if( $a->present()->concluida($usuario, $m) == 1)
                                                                            <div class="col-md-4">
                                                                                <div class="row horizontal-right">
                                                                                    <i class="fas fa-check-circle text-20-pt text-green" title="Concluída"></i>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            @if( $aula->id != $a->id)
                                                                                <div class="col-md-4 iniciar">
                                                                                    <div class="row horizontal-right">
                                                                                        <a href="{{ route('sistema.alunos.vod.curso.player', [$curso->slug, $m->slug, $a->slug]) }}" class="text-white btn-purple btn-small bold text-15-pt">Iniciar Aula</a>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul> 
                                                    </div>   
                                                @endforeach
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>
                                </div>
                            </div>                            
                        </div>

                    </div>
                    

            </div>


            </div>
            <!-- /.row -->



        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@stop
@section('scripts')
    <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" />
    <link href="{{ assets('sistema/alunos/dist/css/videojs-hls-quality-selector.css') }}" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <script src="https://vjs.zencdn.net/7.8.4/video.js"></script>
    <script src="https://cdn.rawgit.com/phhu/videojs-abloop/master/dist/videojs-abloop.min.js"></script>	
    <script src="https://unpkg.com/@videojs/http-streaming@2.2.2/dist/videojs-http-streaming.min.js"></script>
    <script src="//cdn.sc.gl/videojs-hotkeys/latest/videojs.hotkeys.min.js"></script>
    <script src="{{ assets('sistema/alunos/dist/js/videojs-contrib-quality-levels.min.js') }}"></script>
    <script src="{{ assets('sistema/alunos/dist/js/videojs-hls-quality-selector.min.js') }}"></script>
    <script>
        jQuery(document).ready(function(){
            var video = videojs("vid",{ 
                plugins: {
                    abLoopPlugin: {
                        createButtons: true,
                    }
                },
                autoplay: true,
            });
            video.src({
                src: '{{ $url }}',
                //type: 'application/x-mpegURL',
                //withCredentials: true
            });
            video.hlsQualitySelector({
                displayCurrentQuality: true,
            });
            //video.muted(true);
            video.ready(function() {
                var promise = video.play();
                if (promise !== undefined) {
                  promise.then(function() {
                    console.log('Autoplay started!');
                  }).catch(function(error) {
                    console.log('Autoplay was prevented.');
                  });
                  $('body').find('.abLoopButton.start').html('A');
                  $('body').find('.abLoopButton.end').html('B');
                }
              });
            video.on('timeupdate', function (e) {
                if (video.currentTime() > 0.001 && video.currentTime() < 2) {
                    //video.muted(false);
                }
            });
            video.on('ended', function() {
                @if($controles['proximo'])
                    window.location.href = '{{ $controles['proximo'] }}';
                @endif
            });
            video.ready(function() {
                this.hotkeys({
                volumeStep: 0.1,
                seekStep: 5,
                enableMute: true,
                enableFullscreen: true,
                enableNumbers: false,
                enableVolumeScroll: true,
                enableHoverScroll: true,
      
                // Mimic VLC seek behavior, and default to 5.
                seekStep: function(e) {
                  if (e.ctrlKey && e.altKey) {
                    return 5*60;
                  } else if (e.ctrlKey) {
                    return 60;
                  } else if (e.altKey) {
                    return 10;
                  } else {
                    return 5;
                  }
                },
      
                // Enhance existing simple hotkey with a complex hotkey
                fullscreenKey: function(e) {
                  // fullscreen with the F key or Ctrl+Enter
                  return ((e.which === 70) || (e.ctrlKey && e.which === 13));
                },
      
                // Custom Keys
                customKeys: {
      
                  // Add new simple hotkey
                  startLoop: {
                    key: function(e) {
                      // Toggle something with A Key
                      return (e.which === 65);
                    },
                    handler: function(player, options, e) {
                        $('.vjs-progress-control.vjs-control .inicio').remove();
                        $('.vjs-progress-control.vjs-control .fim').remove();
                        $pos = parseFloat($('.vjs-play-progress.vjs-slider-bar').css('width')) + 7;
                        $('.vjs-progress-control.vjs-control').append('<span class="inicio">A</span>');
                        $('.vjs-progress-control.vjs-control .inicio').css('left', $pos + 'px');
                        $('.vjs-progress-control.vjs-control .inicio').css('position', 'absolute');
                        $('.vjs-progress-control.vjs-control .inicio').css('top', '1px');
                        video.abLoopPlugin.enable();
                        video.abLoopPlugin.setStart(video.currentTime());
                        $('body').find('.abLoopButton.start').html('A');
                        $('body').find('.abLoopButton.end').html('B');
                    }
                  },
      
                  endLoop: {
                    key: function(e) {
                      // Toggle something with B Key
                      return (e.which === 66);
                    },
                    handler: function(player, options, e) {
                        $('.vjs-progress-control.vjs-control .fim').remove();
                        $pos = parseFloat($('.vjs-play-progress.vjs-slider-bar').css('width')) + 7;
                        $('.vjs-progress-control.vjs-control').append('<span class="fim">B</span>');
                        $('.vjs-progress-control.vjs-control .fim').css('left', $pos + 'px');
                        $('.vjs-progress-control.vjs-control .fim').css('position', 'absolute');
                        $('.vjs-progress-control.vjs-control .fim').css('top', '1px');
                        video.abLoopPlugin.setEnd(video.currentTime());
                        video.abLoopPlugin.playLoop();
                        $('body').find('.abLoopButton.start').html('A');
                        $('body').find('.abLoopButton.end').html('B');
                    }
                  },

                  playLoop: {
                    key: function(e) {
                      // Toggle something with X Key
                      return (e.which === 88);
                    },
                    handler: function(player, options, e) {
                        $('.vjs-progress-control.vjs-control .inicio').remove();
                        $('.vjs-progress-control.vjs-control .fim').remove();
                        video.abLoopPlugin.toggle();
                    }
                  },
      
                  // Add new complex hotkey
      
                  // Override number keys example from https://github.com/ctd1500/videojs-hotkeys/pull/36
                  numbersKey: {
                    key: function(event) {
                      // Override number keys
                      return ((event.which > 47 && event.which < 59) || (event.which > 95 && event.which < 106));
                    },
                    handler: function(player, options, event) {
                      // Do not handle if enableModifiersForNumbers set to false and keys are Ctrl, Cmd or Alt
                      if (options.enableModifiersForNumbers || !(event.metaKey || event.ctrlKey || event.altKey)) {
                        var sub = 48;
                        if (event.which > 95) {
                          sub = 96;
                        }
                        var number = event.which - sub;
                        player.currentTime(player.duration() * number * 0.1);
                      }
                    }
                  },
      
                  emptyHotkey: {
                    // Empty
                  },
      
                  withoutKey: {
                    handler: function(player, options, event) {
                        console.log('withoutKey handler');
                    }
                  },
      
                  withoutHandler: {
                    key: function(e) {
                        return true;
                    }
                  },
      
                  malformedKey: {
                    key: function() {
                      console.log('I have a malformed customKey. The Key function must return a boolean.');
                    },
                    handler: function(player, options, event) {
                      //Empty
                    }
                  }
                }
              });
            });

            $('video').focus();
            $('body').on('click touchstart', '.abLoopButton.start', function(){
                $('.vjs-progress-control.vjs-control .inicio').remove();
                $('.vjs-progress-control.vjs-control .fim').remove();
                $('body').find('.abLoopButton.start').html('A');
                $('body').find('.abLoopButton.end').html('B');
                $pos = parseFloat($('.vjs-play-progress.vjs-slider-bar').css('width')) + 7;
                $('.vjs-progress-control.vjs-control').append('<span class="inicio">A</span>');
                $('.vjs-progress-control.vjs-control .inicio').css('left', $pos + 'px');
                $('.vjs-progress-control.vjs-control .inicio').css('position', 'absolute');
                $('.vjs-progress-control.vjs-control .inicio').css('top', '1px');
                video.abLoopPlugin.enable();
                video.abLoopPlugin.setStart(video.currentTime());
                $('body').find('.abLoopButton.start').html('A');
                $('body').find('.abLoopButton.end').html('B');
            })
            $('body').on('click touchstart', '.abLoopButton.end', function(){
                $('.vjs-progress-control.vjs-control .fim').remove();
                $('body').find('.abLoopButton.start').html('A');
                $('body').find('.abLoopButton.end').html('B');
                $pos = parseFloat($('.vjs-play-progress.vjs-slider-bar').css('width')) + 7;
                $('.vjs-progress-control.vjs-control').append('<span class="fim">B</span>');
                $('.vjs-progress-control.vjs-control .fim').css('left', $pos + 'px');
                $('.vjs-progress-control.vjs-control .fim').css('position', 'absolute');
                $('.vjs-progress-control.vjs-control .fim').css('top', '1px');
                video.abLoopPlugin.setEnd(video.currentTime());
                video.abLoopPlugin.playLoop();
                $('body').find('.abLoopButton.start').html('A');
                $('body').find('.abLoopButton.end').html('B');
            });
            $('body').on('touchstart', '.abLoopButton.enabled', function(){
                $(this).trigger('click');
            });
        })
    </script> 
@stop
