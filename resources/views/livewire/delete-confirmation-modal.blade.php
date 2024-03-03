<div class="modal fade delete-modal" id="deleteModal" tabindex="-1" aria-hidden="true">
    <!-- Contenu de la modal de suppression -->
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-body">
                <div class="d-flex gap-3">
                    <span class="modal-icon-container">
                        <i class="bi bi-exclamation-triangle d-block modal-icon rounded-circle text-white"></i>
                    </span>
                    <div class="content-body">
                        <h3>Êtes-vous sûr ?</h3>
                        <p>Cette action ne peut pas être annulée</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click.prevent="closeModal()" type="button" class="btn btn-secondary">
                    Annuler
                </button>
                <button wire:click.prevent="deleteItem()" class="btn btn-danger">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script>
    /*document.addEventListener('livewire:load', function () {

        console.log('Livewire loaded');
        Livewire.on('openModal', function (item) {
            window.livewire.emit('show', item);
        });

        Livewire.on('closeModal', function () {
            $('#deleteModal').modal('hide');
        });
    });*/
</script>
