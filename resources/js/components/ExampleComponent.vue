<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component. {{ name }} {{ user[1] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            name: "Zarko"
        }
    },
    props: ['user'],
    mounted() {
        var path = window.location.pathname;

        if (path === '/') {
            path = '/profile';
        }
        // Check if the page is not a login, register, or admin page
        if (path !== '/login' && path !== '/register' && !path.includes('admin')) {

            // Fetch page category data and print elements
            axios.post("/page_category", {name: path})
                .then(response => {
                    const res = response.data;
                    const idArray = res.map(item => item.field_category_id);

                    console.log(response);
                    if (idArray.length > 0) {
                        // printElements(idArray);
                    } else {
                        // hideSpinner();
                    }
                })
                .catch(error => {
                    alert(error);
                    console.error('Error fetching page category:', error);
                });

        }

        console.log(path);
    }
}
</script>
