
                            @if ($info['dispatch'][0]->status == 0)
                                <h1>SOLICITAÇÃO DE DESPACHO</h1>
                                <h3>Sua posição na fila é:</h3>{{ $info['fila'] }}º
                                <div class="fs-25">
                                    @if ($info['fila'] == 1)
                                    Em breve você será chamado.
                                    @endif
                                <br>
                                 Aguardando atendimento.<br>
                                </div>
                            @elseif($info['dispatch'][0]->status == 1)
                                <h1>SOLICITAÇÃO DE DESPACHO</h1>
                                <p class="c-b p-t-85 p-b-85 fs-30">Chegou a sua vez desloque-se até a sala do comandante.</p>
                                <div class="fs-25 ">
                                </div>
                            @endif
