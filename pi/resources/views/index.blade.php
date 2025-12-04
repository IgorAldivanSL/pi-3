<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Premium</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <header>
        <div class="header-container">
            <img class="logo" src="{{ asset('img/Logo.png') }}" alt="Logo">

            <div class="menu-container">
                <button class="menu-toggle">☰</button>

                <nav>
                    <ul>
                        <li><a href="#home">Início</a></li>
                        <li><a href="#cafes">Cafés</a></li>
                        <li><a href="#beneficios">Vantagens</a></li>
                        <li><a href="#sobre">Sobre</a></li>
                        <li><a href="#reviews">Depoimentos</a></li>
                    </ul>
                </nav>

                <a href="{{ auth('cliente')->check() ? route('cliente.dashboard') : route('cliente.loginView') }}" 
                    class="icone-carrinho">
                    <i class="fas fa-shopping-cart"></i>
                </a>

                <a href="{{ route('cliente.loginView') }}" class="botao-login">Login</a>
            </div>
        </div>
    </header>

    <section class="banner" id="home">
        <div class="content-wrapper" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="coluna-1 conteudo-texto">
                <h1>Descubra o sabor do café perfeito</h1>
                <p>Grãos selecionados, torrefação artesanal e frescor incomparável. Assine ou compre seu café favorito.</p>

                <div class="botoes">
                    <img class="img-mobile" src="{{ asset('img/mobile.png') }}" alt="">
                    <a href="#cafes"><button class="botao-reservar">Ver cafés</button></a>
                    <a href="https://wa.me/"><button class="botao-duvidas">Tirar dúvidas</button></a>
                </div>
            </div>

            <div class="coluna-2 imagem-principal">
                <img src="{{ asset('img/ImagemPrincipal.png') }}" alt="Café especial">
            </div>
        </div>
    </section>

    <section id="cafes" class="cafes-lista">
        <div class="content-wrapper">
            <h2>Nossos Cafés</h2>

            {{-- INÍCIO DO CARROSSEL --}}
            <div class="carousel-wrapper">
                
                {{-- Botão de Navegação Esquerdo --}}
                <button class="carousel-nav nav-prev" onclick="scrollCarousel(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>

                {{-- Container que ROLA HORIZONTALMENTE --}}
                <div class="carousel-track" id="cafes-carousel">
                    @foreach ($produtos as $produto)
                        <article class="cafe-card">
                            <div class="cafe-imagem">
                                <img src="{{ $produto->imagem ? Storage::url($produto->imagem) : asset('img/default.png') }}" 
                                    alt="Imagem do {{ $produto->nome }}">
                            </div>
                            
                            {{-- Título e Preço --}}
                            <div class="cafe-header">
                                <h3>{{ $produto->nome }}</h3>
                                <div class="cafe-preco">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </div>
                            </div>

                            <p class="cafe-descricao">{{ $produto->descricao }}</p>

                            {{-- Detalhes do Produto --}}
                            <div class="cafe-info">
                                <div class="info-item">
                                    <span>Categoria:</span>
                                    <span class="info-dado">{{ $produto->categoria }}</span>
                                </div>

                                <div class="info-item">
                                    <span>Peso:</span>
                                    <span class="info-dado">{{ $produto->peso }}g</span>
                                </div>

                                <div class="info-item">
                                    <span>Torra:</span>
                                    <span class="info-dado">{{ $produto->tipo_torra }}</span>
                                </div>
                            </div>

                            {{-- Botão Comprar --}}
                            <a href="{{ auth('cliente')->check() 
                                        ? route('cliente.assinaturas.checkout', $produto->id) 
                                        : route('cliente.loginView') }}">
                                <button class="btn-comprar">
                                    <span>Comprar</span>
                                    <i class="fas fa-mug-hot"></i>
                                </button>
                            </a>

                        </article>
                    @endforeach
                </div>
                
                {{-- Botão de Navegação Direito --}}
                <button class="carousel-nav nav-next" onclick="scrollCarousel(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>

            </div>
            {{-- FIM DO CARROSSEL --}}
            
        </div>
    </section>
    
    <section id="beneficios" class="beneficios-section">
        <div class="content-wrapper" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="coluna-1 beneficios-imagem">
                <img src="{{ asset('img/GraosFundoAmarelo.png') }}" alt="Café premium">
            </div>

            <div class="coluna-2 beneficios-texto-container">
                <h2>Por que nosso café é especial?</h2>
                <p>
                    Selecionamos grãos das melhores regiões produtoras e torramos pequenos lotes para garantir sabor,
                    aroma e qualidade impecáveis.
                </p>

                <div class="beneficios-lista">
                    <div class="beneficio-item">
                        <i class="icon fa-solid fa-circle-check"></i>
                        <div>
                            <h3>Torra artesanal</h3>
                            <p>Sabor mais intenso e aroma irresistível.</p>
                        </div>
                    </div>

                    <div class="beneficio-item">
                        <i class="icon fa-solid fa-circle-check"></i>
                        <div>
                            <h3>Grãos selecionados</h3>
                            <p>Qualidade elevada do plantio até a xícara.</p>
                        </div>
                    </div>

                    <div class="beneficio-item">
                        <i class="icon fa-solid fa-circle-check"></i>
                        <div>
                            <h3>Perfeito para todos os métodos</h3>
                            <p>Filtro, prensa, espresso e muito mais.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="sobre" class="secao-sobre">
        <div class="content-wrapper" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="coluna-1 sobre-texto">
                <h2>Sobre nós</h2>
                <p>Somos apaixonados por café e dedicados a levar até você os melhores grãos.</p>
                <img class="img-mobile" src="{{ asset('assets/sobre-cafe.png') }}" alt="">
                <button class="botao-reservar">Conhecer mais</button>
            </div>

            <div class="coluna-2 sobre-imagem">
                <img src="{{ asset('img/XicaraVerde.png') }}" alt="Café artesanal">
            </div>
        </div>
    </section>

    <section id="reviews" class="reviews-container">
        <div class="content-wrapper">
            <h2>O que nossos clientes dizem</h2>

            <div class="reviews">
                <div class="review-card">
                    <img src="https://cdn.vectorstock.com/i/500p/08/19/gray-photo-placeholder-icon-design-ui-vector-35850819.jpg" alt="Foto de Ana Carolina">
                    <h3>Ana Carolina</h3>
                    <div class="stars">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <p>“O melhor café que já experimentei!”</p>
                </div>

                <div class="review-card">
                    <img src="https://cdn.vectorstock.com/i/500p/08/19/gray-photo-placeholder-icon-design-ui-vector-35850819.jpg" alt="Foto de Rafael Souza">
                    <h3>Rafael Souza</h3>
                    <div class="stars">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <p>“Entrega rápida e qualidade excelente.”</p>
                </div>

                <div class="review-card">
                    <img src="https://cdn.vectorstock.com/i/500p/08/19/gray-photo-placeholder-icon-design-ui-vector-35850819.jpg" alt="Foto de Mariana Alves">
                    <h3>Mariana Alves</h3>
                    <div class="stars">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <p>“Grãos frescos e sabor equilibrado!”</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contato" class="contato-section">
        <div class="content-wrapper" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="coluna-1 contato-texto">
                <h2>Fale conosco</h2>
                <p>Tire dúvidas sobre assinaturas, preparo ou pedidos.</p>
                <img src="{{ asset('img/XicaraAmarela.png') }}" alt="Xícara de Café">
            </div>

            <div class="coluna-2 contato-form">
                <form action="" method="post">
                    @csrf

                    <div class="input-group">
                        <input type="text" placeholder="Nome Completo" name="nome" required>
                        <input type="email" placeholder="Seu E-mail" name="email" required>
                    </div>

                    <input type="tel" placeholder="Telefone / WhatsApp" name="telefone" required>
                    <textarea placeholder="Sua Mensagem" name="mensagem" rows="4" required></textarea>

                    <button class="enviar-contato" type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="content-wrapper">
            <p>© 2024 Café Premium. Todos os direitos reservados.</p>
        </div>
    </footer>

    {{-- SCRIPTS --}}
    <script>
        /**
         * Rola o carrossel horizontalmente.
         * @param {number} direction - 1 para direita (next), -1 para esquerda (prev).
         */
        function scrollCarousel(direction) {
            const carousel = document.getElementById('cafes-carousel');
            if (!carousel) return;
            
            // Define o quanto rolar. Usaremos a largura de um card (320px) + gap (30px) = 350px.
            const scrollAmount = 350; 

            // Rola o carrossel suavemente
            carousel.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>

</body>
</html>