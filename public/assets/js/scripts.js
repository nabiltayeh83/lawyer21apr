 $(document).ready(function() {
        // Initializes search overlay plugin.
        // Replace onSearchSubmit() and onKeyEnter() with
        // your logic to perform a search and display results
        $('[data-pages="search"]').search({
            searchField: '#overlay-search',
            closeButton: '.overlay-close',
            suggestions: '#overlay-suggestions',
            brand: '.brand',
            onSearchSubmit: function(searchString) {
                console.log("Search for: " + searchString);
            },
            onKeyEnter: function(searchString) {
                console.log("Live search for: " + searchString);
                var searchField = $('#overlay-search');
                var searchResults = $('.search-results');
                clearTimeout($.data(this, 'timer'));
                searchResults.fadeOut("fast");
                var wait = setTimeout(function() {
                    searchResults.find('.result-name').each(function() {
                        if (searchField.val().length != 0) {
                            $(this).html(searchField.val());
                            searchResults.fadeIn("fast");
                        }
                    });
                }, 500);
                $(this).data('timer', wait);
            }
        });

 

//====================================
//     datepicker
//====================================
  $( function() {
    $( ".start_date" ).datepicker();
    $( ".end_date" ).datepicker();
  } );

     
//====================================
//     file upload
//====================================
     $('.input-file-container input[type="file"]').on('change' , function() {



         if ( $(this).val().length > 0 )
             {
                 $(this).parents('.input-file-container').addClass('active');
                  $(this).parents('.input-file-container').find('.input-file-trigger span').html($(this).val());
             }

         else {
              $(this).parents('.input-file-container').removeClass('active');
               $(this).parents('.input-file-container').find('.input-file-trigger span').html('  اختر ملف ');
         }

     } )


    })
