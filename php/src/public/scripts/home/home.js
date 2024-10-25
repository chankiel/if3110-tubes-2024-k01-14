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

document.addEventListener("DOMContentLoaded", function() {
    const toggleFilterButton = document.querySelector(".toggle-filter");
    const filterSortElement = document.querySelector(".filter-sort");
    
    toggleFilterButton.addEventListener("click", function() {
        filterSortElement.style.display = (filterSortElement.style.display === "none" || filterSortElement.style.display === "") ? "block" : "none";
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

    const searchInputs = document.querySelectorAll(".job-search");
    const filterCheckboxesLeft = document.querySelectorAll('.search-filter-left-sidebar input[name="filter[]"]');
    const filterCheckboxesRight = document.querySelectorAll('.search-filter-right-sidebar input[name="filter[]"]');
    const jobTypeCheckboxesLeft = document.querySelectorAll('.search-filter-left-sidebar input[name="job-type[]"]');
    const jobTypeCheckboxesRight = document.querySelectorAll('.search-filter-right-sidebar input[name="job-type[]"]');
    const sortRadiosLeft = document.querySelectorAll('.search-filter-left-sidebar input[name="job_sort"]');
    const sortRadiosRight = document.querySelectorAll('.search-filter-right-sidebar input[name="job_sort"]');

    function syncCheckboxes(sourceCheckbox, checkboxesToSync) {
        checkboxesToSync.forEach(checkbox => {
            if (checkbox.value === sourceCheckbox.value) {
                checkbox.checked = sourceCheckbox.checked;
            }
        });
    }

    function syncInputs(sourceInput, inputToSync) {
        inputToSync.value = sourceInput.value;
    }

    function syncRadios(sourceRadio, radiosToSync) {
        radiosToSync.forEach(radio => {
            if (radio.value === sourceRadio.value) {
                radio.checked = true;
            } else {
                radio.checked = false;
            }
        });
    }

    filterCheckboxesLeft.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            syncCheckboxes(this, filterCheckboxesRight);
            debouncedFetchJobs();
        });
    });

    filterCheckboxesRight.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            syncCheckboxes(this, filterCheckboxesLeft);
            debouncedFetchJobs();
        });
    });

    jobTypeCheckboxesLeft.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            syncCheckboxes(this, jobTypeCheckboxesRight);
            debouncedFetchJobs();
        });
    });

    jobTypeCheckboxesRight.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            syncCheckboxes(this, jobTypeCheckboxesLeft);
            debouncedFetchJobs();
        });
    });

    sortRadiosLeft.forEach(radio => {
        radio.addEventListener("change", function() {
            syncRadios(this, sortRadiosRight);
            debouncedFetchJobs();
        });
    });

    sortRadiosRight.forEach(radio => {
        radio.addEventListener("change", function() {
            syncRadios(this, sortRadiosLeft);
            debouncedFetchJobs();
        });
    });

    searchInputs[0].addEventListener("input", function() {
        syncInputs(this, searchInputs[1]);
        debouncedFetchJobs();
    });

    searchInputs[1].addEventListener("input", function() {
        syncInputs(this, searchInputs[0]);
        debouncedFetchJobs();
    });

    sortRadiosLeft.forEach(radio => radio.addEventListener("change", debouncedFetchJobs));
    sortRadiosRight.forEach(radio => radio.addEventListener("change", debouncedFetchJobs));
});

document.querySelector('.add-job').addEventListener('click', function() {
    window.location.href = '/jobs/add';
});
