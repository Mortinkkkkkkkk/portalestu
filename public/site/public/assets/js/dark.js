// Js que alterna o modo escuro
$('document').ready(
    $('.toggle-checkbox').click(
        function() {
            $('body').toggleClass("bg-dark-mode");
            $('p').toggleClass("txt-dark");
            $('h1').toggleClass("txt-dark");
            $('.container-posts').toggleClass("container-posts-dark");
            $('.card').toggleClass("post-dark");
        }
    )
);