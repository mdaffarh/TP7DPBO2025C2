<div class="container mx-auto p-4">
    <!-- Success Message -->
    <?php if (isset($_GET['success'])): ?>
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>

    <!-- Header and Add Button -->
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Character Management</h3>
        <button
            onclick="showAddForm()"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            Add Character
        </button>
    </div>

    <!-- Search Form -->
    <form method="GET" class="mb-4 flex items-center space-x-2">
        <input type="hidden" name="page" value="characters">
        <input
            type="text"
            name="search"
            placeholder="Search character..."
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2 w-64">
        <button
            type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Search
        </button>
    </form>

    <!-- Character Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Element</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weapon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $search = $_GET['search'] ?? null;
                    $characters = $character->getAll($search);
                    ?>
                    <?php foreach ($characters as $c): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($c['id']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($c['name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($c['hp']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($c['level']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($c['element']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($c['weapon']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-2">
                                    <button
                                        onclick="window.location='?page=characters&edit=<?= $c['id'] ?>'"
                                        class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition-colors"
                                        title="Edit">
                                        Edit
                                    </button>
                                    <button
                                        onclick="confirmDelete(<?= $c['id'] ?>)"
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors"
                                        title="Delete">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Character Form (Always Hidden Initially) -->
    <div id="addForm" class="mt-8 bg-white shadow-md rounded-lg p-6 hidden">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Character</h3>
        <form method="POST" class="space-y-4">
            <div>
                <label for="add_name" class="block text-sm font-medium text-gray-700">Character Name</label>
                <input
                    type="text"
                    id="add_name"
                    name="name"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label for="add_hp" class="block text-sm font-medium text-gray-700">HP</label>
                <input
                    type="text"
                    id="add_hp"
                    name="hp"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label for="add_level" class="block text-sm font-medium text-gray-700">Level</label>
                <input
                    type="number"
                    id="add_level"
                    name="level"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label for="add_element" class="block text-sm font-medium text-gray-700">Element</label>
                <select
                    id="add_element"
                    name="element_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="" selected disabled></option>
                    <?php foreach ($element->getAll() as $e): ?>
                        <option value="<?= htmlspecialchars($e['id']) ?>"><?= htmlspecialchars($e['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="add_weapon" class="block text-sm font-medium text-gray-700">Weapon</label>
                <select
                    id="add_weapon"
                    name="weapon_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="" selected disabled></option>
                    <?php foreach ($weapon->getAll() as $w): ?>
                        <option value="<?= htmlspecialchars($w['id']) ?>"><?= htmlspecialchars($w['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button
                    type="button"
                    onclick="hideAddForm()"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <button
                    type="submit"
                    name="add_character"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add Character
                </button>
            </div>
        </form>
    </div>

    <!-- Edit Character Form (Only shown when editing) -->
    <?php if (isset($_GET['edit'])): ?>
        <?php $editData = $character->find($_GET['edit']); ?>
        <div id="editForm" class="mt-8 bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Character </h3>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">

                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Character Name</label>
                    <input
                        type="text"
                        id="edit_name"
                        name="name"
                        value="<?= htmlspecialchars($editData['name']) ?>"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="edit_hp" class="block text-sm font-medium text-gray-700">HP</label>
                    <input
                        type="text"
                        id="edit_hp"
                        name="hp"
                        value="<?= htmlspecialchars($editData['hp']) ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="edit_level" class="block text-sm font-medium text-gray-700">Level</label>
                    <input
                        type="number"
                        id="edit_level"
                        name="level"
                        value="<?= htmlspecialchars($editData['level']) ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm/text-sm">
                </div>

                <div>
                    <label for="edit_element" class="block text-sm font-medium text-gray-700">Element</label>
                    <select
                        id="edit_element"
                        name="element_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <?php foreach ($element->getAll() as $e): ?>
                            <option value="<?= htmlspecialchars($e['id']) ?>" <?= $editData['element_id'] === $e['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="edit_weapon" class="block text-sm font-medium text-gray-700">Weapon</label>
                    <select
                        id="edit_weapon"
                        name="weapon_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <?php foreach ($weapon->getAll() as $w): ?>
                            <option value="<?= htmlspecialchars($w['id']) ?>" <?= $editData['weapon_id'] === $w['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($w['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="flex justify-end space-x-3 pt-4">
                    <button
                        type="button"
                        onclick="window.location='?page=characters'"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        name="update_character"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Character
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    function showAddForm() {
        if (document.getElementById('editForm')) {
            document.getElementById('editForm').classList.add('hidden');
        }
        document.getElementById('addForm').classList.remove('hidden');
    }

    function showEditForm() {
        document.getElementById('editForm').classList.remove('hidden');
    }

    function hideAddForm() {
        document.getElementById('addForm').classList.add('hidden');
    }

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this characters?')) {
            window.location = `?page=characters&delete_character=${id}`;
        }
    }

    // Automatically show add form if coming from edit with empty ID
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_GET['show_add'])): ?>
            showAddForm();
        <?php endif; ?>
    });
</script>