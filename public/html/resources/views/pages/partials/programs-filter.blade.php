@php

$category = request()->get('category', []);
$status = request()->get('status', []);
$dateFrom = request()->get('date_from', '');
$dateTo = request()->get('date_to', '');
@endphp
<form method="GET" action="{{ route('programs') }}" class="mb-5 mb-md-0" id="programs-filter">
    <div class="row gy-3">
        <div class="col-sm-6 col-md-3 position-relative">
            <label>
                Категория
            </label>

            <div class="dropdown dropdown-multiselect w-100">
                <button
                    class="form-select w-100 text-start text-secondary"
                    type="button"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    data-selected-text="Избрани {count} категории"
                    id="categoriesDropdown">
                    Избери категория
                </button>

                <ul class="dropdown-menu p-2" aria-labelledby="categoriesDropdown">
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input
                                class="form-check-input m-0" type="checkbox" name="category[]" value="1" {{ in_array(1, $category) ? 'checked' : '' }}>
                           Категория 1
                        </label>
                    </li>

                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input m-0" type="checkbox" name="category[]" value="2" {{ in_array(2, $category) ? 'checked' : '' }}>
                            Категория 2
                        </label>
                    </li>

                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input m-0" type="checkbox" name="category[]" value="3" {{ in_array(3, $category) ? 'checked' : '' }}>
                            Категория 3
                        </label>
                    </li>

                </ul>
            </div>

        </div>
        <div class="col-sm-6 col-md-3">
            <label>
                Статус
            </label>
            <div class="dropdown dropdown-multiselect w-100">
                <button
                    class="form-select w-100 text-start text-secondary"
                    type="button"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    data-selected-text="Избрани {count} статуса"
                    id="statusDropdown">
                    Избери статус
                </button>

                <ul class="dropdown-menu p-2" aria-labelledby="statusDropdown">
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input m-0" type="checkbox" name="status[]" value="1" {{ in_array(1, $status) ? 'checked' : '' }}>
                            Статус 1
                        </label>
                    </li>

                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input m-0" type="checkbox" name="status[]" value="2" {{ in_array(2, $status) ? 'checked' : '' }}>
                            Статус 2
                        </label>
                    </li>

                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input m-0" type="checkbox" name="status[]" value="3" {{ in_array(3, $status) ? 'checked' : '' }}>
                            Статус 3
                        </label>
                    </li>

                </ul>
            </div>


        </div>
        <div class="col-sm-6 col-md-3">
            <label for="date-from">
                От
            </label>
            <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}" aria-label="срок от" id="date-from">
        </div>
        <div class="col-sm-6 col-md-3">
            <label for="date-to">
                До
            </label>
            <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}" aria-label="срок до" id="date-to">
        </div>
    </div>
    <div class="row position-absolute">
        <div class="col-sm-12 mt-3">
            <button type="submit" class="btn btn-light btn-sm">
                Филтрирай
            </button>
            <button type="reset" class="btn btn-light btn-sm">
                Изчисти всички
            </button>
        </div>
    </div>
</form>