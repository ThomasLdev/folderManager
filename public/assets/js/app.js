// ADD NEW SKU IN NEW FORM //
let editPage = document.getElementsByClassName("editSku");
let newPage = document.getElementsByClassName("newSku");

if (editPage.length !== 0 || newPage.length !== 0) {
    $(document).ready(function () {
        /// Get the div that holds the collection of tags
        let skusDiv = $('div.skus');
        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        skusDiv.data('index', skusDiv.find('input').length);
        // on click on add image or add video (current target)
        $('body').on('click', '.add_item_link', function (e) {
            let $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
            // add a new tag form (see next code block)
            addFormToCollection($collectionHolderClass);
        })
        // add a delete link to all of the existing skus
        // skusDiv.find('div.sku-bloc').each(function () {
        //     addTagFormDeleteLink($(this));
        // });

        // Toggle products
        let clicked = 0;
        $('.form-extend-btn').click(function () {
            if (clicked === 0) {
                $(this).parent().find('.sku-fields-bloc').toggleClass('active');
                clicked = 1;
                $(this).text('Fermer');
            } else {
                $(this).parent().find('.sku-fields-bloc').removeClass('active');
                $(this).text('Voir');
                clicked = 0;
            }
        });

        // IF BLOC-NEW AND CLIC ON HOME, WARN THAT SKU WILL NOT BE SAVED
        let navBtns = document.querySelectorAll('.btn-top');
        navBtns.forEach(function (item) {
            item.addEventListener('click', function (e) {
                let newBloc = document.querySelectorAll('.bloc-new');
                if (newBloc.length > 0) {
                    e.preventDefault();
                    alert('Attention, votre SKU n\'est pas sauvegardé');
                }
            });
        });
    });

    function addFormToCollection($collectionHolderClass) {
        // Get the div that holds the collection of tags
        let $collectionHolder = $('.' + $collectionHolderClass);
        // Get the data-prototype explained earlier
        let prototype = $collectionHolder.data('prototype');
        // get the new index
        let index = $collectionHolder.data('index');
        let newForm = prototype;
        // You need this only if you didn't set 'label' => false in your tags field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, index);
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);
        // Display the form in the page in an li, before the "Add a tag" link li
        let $newFormDiv = $('<div class="row sku-bloc bloc-new bg-light"></div>').append(newForm);
        // Add the new form at the end of the list
        $collectionHolder.append($newFormDiv)
        let $tagFormDiv = $newFormDiv;
        let $removeFormButton = $('<button class="btn bg-danger btn-sku-remove" type="button"><i class="fas fa-trash-alt"></i></button>');
        $tagFormDiv.append($removeFormButton);
        $removeFormButton.on('click', function () {
            // remove the li for the tag form
            $tagFormDiv.remove();
        });
    }

    function addTagFormDeleteLink($skuFormDiv) {
        let $removeFormButton = $('<button class="btn bg-danger btn-sku-remove" type="button"><i class="fas fa-trash-alt"></i></button>');
        $skuFormDiv.append($removeFormButton);

        $removeFormButton.on('click', function () {
            // remove the div for the tag form
            $skuFormDiv.closest('.sku-bloc').remove();
        });
    }
}