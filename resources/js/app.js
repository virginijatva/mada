const { identity } = require('lodash');

require('./bootstrap');

window.addEventListener('DOMContentLoaded', (event) => {
    if (document.querySelector('#summernote')) {
        $('#summernote').summernote();
    }
});


window.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#search-field')) {
        const searchField = document.querySelector('#search-field');

        searchField.addEventListener('input', () =>{
            console.log(searchField.value);
            axios.get(masterSearchURL + '?s=' + searchField.value)
            .then(function (response) {
                console.log(response);
                document.querySelector('#master-list').innerHTML = response.data.listHTML;
            })
            .catch(function (error) {
                console.log(error);
            });
        })
    }



    if (document.querySelector('#master-list')) {

        axios.get(masterListURL)
            .then(function (response) {
                console.log(response);
                document.querySelector('#master-list').innerHTML = response.data.listHTML;
            })
            .catch(function (error) {
                console.log(error);
            });

        const button = document.querySelector('.card-header').querySelector('button');

        button.addEventListener('click', () => {
            console.log('KLIK');

            const sortName = document.querySelector('[value=size]');
            const sortDate = document.querySelector('[value=date]');
            const orderAsc = document.querySelector('[value=asc]');
            const orderDesc = document.querySelector('[value=desc]');

            let sort, order;
            if (sortName.checked) {
                sort = 'name';
            }
            else if (sortDate.checked) {
                sort = 'date';
            }
            else {
                sort = 'default';
            }

            if (orderAsc.checked) {
                order = 'asc';
            }
            else if (orderDesc.checked) {
                order = 'desc';
            }
            else {
                order = 'default';
            }
            axios.get(masterListURL + '?sort=' + sort + '&order=' + order)
                .then(function (response) {
                    console.log(response);
                    document.querySelector('#master-list').innerHTML = response.data.listHTML;
                })
                .catch(function (error) {
                    console.log(error);
                });
        })
    }
});

