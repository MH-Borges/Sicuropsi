$(document).ready(function () {
    $('#ProdutosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            search: "<img class='searchIcon' src='../../assets/icons/search.svg'>",
            searchPlaceholder: "Procure um produto...",
            "paginate": {
                "previous": "<img class='setaPagePrev' src='../../assets/icons/seta.svg' onload='SVGInject(this)'>",
                "next": "<img class='setaPageNext' src='../../assets/icons/seta.svg' onload='SVGInject(this)' >",
            }
        },
        "pageLength": 16,
        lengthMenu: [
            [16, 25, 50, -1],
            [16, 25, 50, 'All']
        ],
        "pagingType": "simple_numbers",
        stateSave: true,
    });

    $('#CategoriasTable').DataTable({
        "ordering": false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            search: "<img class='searchIcon' src='../../assets/icons/search.svg'>",
            searchPlaceholder: "Busque uma categoria...",
            "paginate": {
                "previous": "<img class='setaPagePrev' src='../../assets/icons/seta.svg' onload='SVGInject(this)'>",
                "next": "<img class='setaPageNext' src='../../assets/icons/seta.svg' onload='SVGInject(this)' >",
            }
        },
        "pagingType": "simple_numbers",
        stateSave: true,
    });

    $('#SubcategoriasTable').DataTable({
        "ordering": false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            search: "<img class='searchIcon' src='../../assets/icons/search.svg'>",
            searchPlaceholder: "Busque uma sub-categoria...",
            "paginate": {
                "previous": "<img class='setaPagePrev' src='../../assets/icons/seta.svg' onload='SVGInject(this)'>",
                "next": "<img class='setaPageNext' src='../../assets/icons/seta.svg' onload='SVGInject(this)' >",
            }
        },
        "pagingType": "simple_numbers",
        stateSave: true,
    });

    $('#CodigosTable').DataTable({
        "ordering": false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            search: "<img class='searchIcon' src='../../assets/icons/search.svg'>",
            searchPlaceholder: "Busque um código...",
            "paginate": {
                "previous": "<img class='setaPagePrev' src='../../assets/icons/seta.svg' onload='SVGInject(this)'>",
                "next": "<img class='setaPageNext' src='../../assets/icons/seta.svg' onload='SVGInject(this)' >",
            }
        },
        "pagingType": "simple_numbers",
        stateSave: true,
    });
});