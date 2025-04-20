<div class="container mx-auto p-4">
    <!-- Success Message -->
    <?php if (isset($_GET['success'])): ?>
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>

    <!-- Header and Add Button -->
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Weapon Management</h3>
        <button
            onclick="showAddForm()"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            Add Weapon
        </button>
    </div>

    <!-- Weapon Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($weapon->getAll() as $w): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($w['id']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($w['name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($w['type']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($w['power']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex space-x-2">
                                    <button
                                        onclick="window.location='?page=weapons&edit=<?= $w['id'] ?>'"
                                        class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition-colors"
                                        title="Edit">
                                        Edit
                                    </button>
                                    <button
                                        onclick="confirmDelete(<?= $w['id'] ?>)"
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

    <!-- Add Weapon Form (Always Hidden Initially) -->
    <div id="addForm" class="mt-8 bg-white shadow-md rounded-lg p-6 hidden">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Weapon</h3>
        <form method="POST" class="space-y-4">
            <div>
                <label for="add_name" class="block text-sm font-medium text-gray-700">Weapon Name</label>
                <input
                    type="text"
                    id="add_name"
                    name="name"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label for="add_type" class="block text-sm font-medium text-gray-700">Type</label>
                <input
                    type="text"
                    id="add_type"
                    name="type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label for="add_power" class="block text-sm font-medium text-gray-700">Power</label>
                <input
                    type="number"
                    id="add_power"
                    name="power"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
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
                    name="add_weapon"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add Weapon
                </button>
            </div>
        </form>
    </div>

    <!-- Edit Weapon Form (Only shown when editing) -->
    <?php if (isset($_GET['edit'])): ?>
        <?php $editData = $weapon->find($_GET['edit']); ?>
        <div id="editForm" class="mt-8 bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Weapon </h3>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">

                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Weapon Name</label>
                    <input
                        type="text"
                        id="edit_name"
                        name="name"
                        value="<?= htmlspecialchars($editData['name']) ?>"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="edit_type" class="block text-sm font-medium text-gray-700">Type</label>
                    <input
                        type="text"
                        id="edit_type"
                        name="type"
                        value="<?= htmlspecialchars($editData['type']) ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="edit_power" class="block text-sm font-medium text-gray-700">Power</label>
                    <input
                        type="number"
                        id="edit_power"
                        name="power"
                        value="<?= htmlspecialchars($editData['power']) ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm/text-sm">
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button
                        type="button"
                        onclick="window.location='?page=weapons'"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        name="update_weapon"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Weapon
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
        if (confirm('Are you sure you want to delete this weapons?')) {
            window.location = `?page=weapons&delete_weapon=${id}`;
        }
    }

    // Automatically show add form if coming from edit with empty ID
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_GET['show_add'])): ?>
            showAddForm();
        <?php endif; ?>
    });
</script>