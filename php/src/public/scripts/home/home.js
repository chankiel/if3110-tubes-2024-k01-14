function fetchJobs(page = 1) {
    const searchInput = document.getElementById("job-search");
    const filterCheckboxes = document.querySelectorAll('input[name="filter[]"]');
    const jobTypeCheckboxes = document.querySelectorAll('input[name="job-type[]"]');
    const sortRadios = document.querySelectorAll('input[name="job_sort"]');

    const searchQuery = searchInput.value;
    const locationQuery = Array.from(filterCheckboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);
    const jobTypeQuery = Array.from(jobTypeCheckboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);
    const sortQuery = Array.from(sortRadios)
        .find(radio => radio.checked)?.value || '';

    const params = new URLSearchParams({
        search: searchQuery,
        'filter[]': locationQuery,
        'job-type[]': jobTypeQuery,
        sort: sortQuery,
        page: page,
    }).toString();

    const url = `/jobs/search?${params}`;

    const xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const jobListContainer = document.querySelector(".show-jobs");
            jobListContainer.innerHTML = xhr.responseText;
            console.log(xhr.responseText);
            history.replaceState(null, '', `/?${params}`);
        } else {
            console.error(`Error loading jobs: ${xhr.statusText}`);
        }
    };

    xhr.send();
}

$(document).ready(function() {
    $(".toggle-filter").on("click", function() {
        $(".filter-sort").toggle();
    });

    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    const debouncedFetchJobs = debounce(function() {
        fetchJobs(1);
    }, 300);

    const searchInput = document.getElementById("job-search");
    const filterCheckboxes = document.querySelectorAll('input[name="filter[]"]');
    const jobTypeCheckboxes = document.querySelectorAll('input[name="job-type[]"]');
    const sortRadios = document.querySelectorAll('input[name="job_sort"]');

    searchInput.addEventListener("input", debouncedFetchJobs);
    filterCheckboxes.forEach(checkbox => checkbox.addEventListener("change", debouncedFetchJobs));
    jobTypeCheckboxes.forEach(checkbox => checkbox.addEventListener("change", debouncedFetchJobs));
    sortRadios.forEach(radio => radio.addEventListener("change", debouncedFetchJobs));
});
