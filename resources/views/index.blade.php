<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dosen List</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Modern button styles */
        .button-modern {
            background: linear-gradient(90deg, #4F46E5, #3B82F6);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 1rem;
            transition: background 0.3s ease, transform 0.2s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .button-modern:hover {
            background: linear-gradient(90deg, #3B82F6, #4F46E5);
            transform: translateY(-2px);
        }

        .button-modern:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Styled file input */
        .file-input {
            position: relative;
            overflow: hidden;
            display: inline-block;
            cursor: pointer;
        }

        .file-input input[type="file"] {
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto py-10">
        <!-- Heading and Button -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold">Dosen List</h2>
            <button type="button" class="button-modern" onclick="openModal('addDosenModal')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Data Dosen
            </button>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="text-left text-gray-600 uppercase text-sm leading-normal bg-gray-50">
                        <th class="py-3 px-6">NIDN</th>
                        <th class="py-3 px-6">Nama Dosen</th>
                        <th class="py-3 px-6">Tanggal Mulai Tugas</th>
                        <th class="py-3 px-6">Jenjang Pendidikan</th>
                        <th class="py-3 px-6">Bidang Keilmuan</th>
                        <th class="py-3 px-6">Foto Dosen</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($dosens as $d)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $d->nidn }}</td>
                        <td class="py-3 px-6">{{ $d->nama_dosen }}</td>
                        <td class="py-3 px-6">{{ $d->tgl_mulai_tugas }}</td>
                        <td class="py-3 px-6">{{ $d->jenjang_pendidikan }}</td>
                        <td class="py-3 px-6">{{ $d->bidang_keilmuan }}</td>
                        <td class="py-3 px-6"><img src="{{ asset('storage/' . $d->foto_dosen) }}" alt="Foto" class="w-10 h-10 object-cover rounded-full"></td>
                        <td class="py-3 px-6 flex space-x-2">
                            <button class="button-modern" onclick="openModal('detailDosenModal{{ $d->nidn }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Detail
                            </button>
                            <button class="button-modern bg-yellow-500 hover:bg-yellow-600" onclick="openModal('editDosenModal{{ $d->nidn }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 4.879a3 3 0 00-4.243 0l-1.415 1.415a3 3 0 000 4.243l1.415 1.415L12 13.413l1.414-1.415 1.415 1.415 1.415-1.415a3 3 0 000-4.243l-1.415-1.415a3 3 0 00-4.243 0L11.293 9.12l-.707.707-1.415-1.415 1.415-1.415a3 3 0 00-1.415-1.415z" /></svg>
                                Edit
                            </button>
                            <form action="{{ route('dosen.destroy', $d->nidn) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button-modern bg-red-500 hover:bg-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Dosen -->
    <div class="modal hidden fixed inset-0 bg-black bg-opacity-50 justify-center items-center" id="addDosenModal">
        <div class="modal-content bg-white rounded-lg shadow-lg p-6 max-w-lg w-full transition-transform transform scale-95 hover:scale-100 duration-200">
            <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="text-xl font-semibold text-gray-800">Tambah Data Dosen</h5>
                    <button type="button" class="text-gray-600 hover:text-gray-800" onclick="closeModal('addDosenModal')">&times;</button>
                </div>
                <div class="modal-body space-y-4">
                    <div class="form-group">
                        <label for="nidn" class="block text-sm font-medium text-gray-700">NIDN</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="nidn" name="nidn" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_dosen" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="nama_dosen" name="nama_dosen" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_mulai_tugas" class="block text-sm font-medium text-gray-700">Tanggal Mulai Tugas</label>
                        <input type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="tgl_mulai_tugas" name="tgl_mulai_tugas" required>
                    </div>
                    <div class="form-group">
                        <label for="jenjang_pendidikan" class="block text-sm font-medium text-gray-700">Jenjang Pendidikan</label>
                        <select id="jenjang_pendidikan" name="jenjang_pendidikan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            <option value="">--Pilih--</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bidang_keilmuan" class="block text-sm font-medium text-gray-700">Bidang Keilmuan</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="bidang_keilmuan" name="bidang_keilmuan" required>
                    </div>
                    <div class="form-group">
                        <label for="foto_dosen" class="block text-sm font-medium text-gray-700">Foto Dosen</label>
                        <div class="file-input mt-1">
                            <button type="button" class="button-modern">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Upload Foto
                            </button>
                            <input type="file" name="foto_dosen" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex justify-end mt-4">
                    <button type="button" class="button-modern bg-gray-300 hover:bg-gray-400" onclick="closeModal('addDosenModal')">Close</button>
                    <button type="submit" class="button-modern">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Editing Dosen -->
    @foreach($dosens as $d)
    <div class="modal hidden fixed inset-0 bg-black bg-opacity-50 justify-center items-center" id="editDosenModal{{ $d->nidn }}">
        <div class="modal-content bg-white rounded-lg shadow-lg p-6 max-w-lg w-full transition-transform transform scale-95 hover:scale-100 duration-200">
            <form action="{{ route('dosen.update', $d->nidn) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="text-xl font-semibold text-gray-800">Edit Data Dosen</h5>
                    <button type="button" class="text-gray-600 hover:text-gray-800" onclick="closeModal('editDosenModal{{ $d->nidn }}')">&times;</button>
                </div>
                <div class="modal-body space-y-4">
                    <div class="form-group">
                        <label for="nidn" class="block text-sm font-medium text-gray-700">NIDN</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="nidn" name="nidn" value="{{ $d->nidn }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_dosen" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="nama_dosen" name="nama_dosen" value="{{ $d->nama_dosen }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_mulai_tugas" class="block text-sm font-medium text-gray-700">Tanggal Mulai Tugas</label>
                        <input type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="tgl_mulai_tugas" name="tgl_mulai_tugas" value="{{ $d->tgl_mulai_tugas }}" required>
                    </div>
                    <div class="form-group">
                        <label for="jenjang_pendidikan" class="block text-sm font-medium text-gray-700">Jenjang Pendidikan</label>
                        <select id="jenjang_pendidikan" name="jenjang_pendidikan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                            <option value="{{ $d->jenjang_pendidikan }}">{{ $d->jenjang_pendidikan }}</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bidang_keilmuan" class="block text-sm font-medium text-gray-700">Bidang Keilmuan</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" id="bidang_keilmuan" name="bidang_keilmuan" value="{{ $d->bidang_keilmuan }}" required>
                    </div>
                    <div class="form-group">
                        <label for="foto_dosen" class="block text-sm font-medium text-gray-700">Foto Dosen</label>
                        <div class="file-input mt-1">
                            <button type="button" class="button-modern">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Upload Foto
                            </button>
                            <input type="file" name="foto_dosen">
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex justify-end mt-4">
                    <button type="button" class="button-modern bg-gray-300 hover:bg-gray-400" onclick="closeModal('editDosenModal{{ $d->nidn }}')">Close</button>
                    <button type="submit" class="button-modern">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Modal for Detail Dosen -->
    @foreach($dosens as $d)
    <div class="modal hidden fixed inset-0 bg-black bg-opacity-50 justify-center items-center" id="detailDosenModal{{ $d->nidn }}">
        <div class="modal-content bg-white rounded-lg shadow-lg p-6 max-w-lg w-full transition-transform transform scale-95 hover:scale-100 duration-200">
            <div class="modal-header flex justify-between items-center mb-4">
                <h5 class="text-xl font-semibold text-gray-800">Detail Dosen</h5>
                <button type="button" class="text-gray-600 hover:text-gray-800" onclick="closeModal('detailDosenModal{{ $d->nidn }}')">&times;</button>
            </div>
            <div class="modal-body space-y-4">
                <p><strong>NIDN:</strong> {{ $d->nidn }}</p>
                <p><strong>Nama Dosen:</strong> {{ $d->nama_dosen }}</p>
                <p><strong>Tanggal Mulai Tugas:</strong> {{ $d->tgl_mulai_tugas }}</p>
                <p><strong>Jenjang Pendidikan:</strong> {{ $d->jenjang_pendidikan }}</p>
                <p><strong>Bidang Keilmuan:</strong> {{ $d->bidang_keilmuan }}</p>
                <div>
                    <strong>Foto Dosen:</strong>
                    <img src="{{ asset('storage/' . $d->foto_dosen) }}" alt="Foto" class="mt-2 w-24 h-24 object-cover rounded-full">
                </div>
            </div>
            <div class="modal-footer flex justify-end mt-4">
                <button type="button" class="button-modern bg-gray-300 hover:bg-gray-400" onclick="closeModal('detailDosenModal{{ $d->nidn }}')">Close</button>
            </div>
        </div>
    </div>
    @endforeach

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</body>
</html>
