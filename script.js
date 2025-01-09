// document.addEventListener('DOMContentLoaded', () => {
//     const pagarButtons = document.querySelectorAll('.pagar-button');
//     pagarButtons.forEach(button => {
//         button.addEventListener('click', function() {
//             const id = this.getAttribute('data-id');
//             alert( id);
//         });
//     });
// });
document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.modal-button');
    const modal = document.getElementById('editModal');
    const closeButton = document.querySelector('.close-button');

    const modalId = document.getElementById('modal-id');
    let modalId2 = document.getElementById('modal-id2');
    // console.log(modalId2)
    const modalDate = document.getElementById('modal-date');
    const modalAmount = document.getElementById('modal-amount');
    const modalPayed = document.getElementById('modal-payed');
    

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');
            const date = this.getAttribute('data-date');
            const amount = this.getAttribute('data-amount');
            const payed = this.getAttribute('data-payed');
            // alert(id)
            modalId.value = id;
            modalId2.value = 12;
            modalDate.value = date;
            modalAmount.value = amount;
            modalPayed.value = payed;
            modal.style.display = 'block';
        });
    });

    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});
