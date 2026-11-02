<x-layouts.app title="Buat Laporan">
    <section class="py-12 bg-surface min-h-[calc(100vh-64px)]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" x-data="wizardForm()">

            {{-- Progress Bar --}}
            <div class="mb-10">
                <div class="flex items-center justify-between mb-3">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex items-center" :class="index < steps.length - 1 ? 'flex-1' : ''">
                            <div class="flex flex-col items-center">
                                <div :class="currentStep > index ? 'gradient-hero text-white shadow-md' : currentStep === index ? 'bg-primary-100 text-primary-700 ring-4 ring-primary-100' : 'bg-gray-200 text-gray-500'"
                                     class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300">
                                    <template x-if="currentStep > index">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                    <template x-if="currentStep <= index">
                                        <span x-text="index + 1"></span>
                                    </template>
                                </div>
                                <span class="text-[11px] font-medium mt-1.5 hidden sm:block" :class="currentStep >= index ? 'text-primary-700' : 'text-gray-400'" x-text="step"></span>
                            </div>
                            <div x-show="index < steps.length - 1" class="flex-1 h-1 mx-3 rounded-full transition-all duration-500" :class="currentStep > index ? 'bg-gradient-to-r from-primary-500 to-secondary-500' : 'bg-gray-200'"></div>
                        </div>
                    </template>
                </div>
            </div>

            <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data" id="form-laporan">
                @csrf

                {{-- STEP 1: Jenis Laporan --}}
                <div x-show="currentStep === 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Pilih Jenis Laporan</h2>
                        <p class="text-gray-500">Apa yang ingin Anda sampaikan?</p>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <label class="cursor-pointer group">
                            <input type="radio" name="jenis_laporan" value="pengaduan" x-model="form.jenis" class="hidden peer">
                            <div class="bg-white rounded-2xl p-8 border-2 border-gray-100 peer-checked:border-primary-500 peer-checked:bg-primary-50/50 hover-lift transition-all text-center peer-checked:shadow-lg">
                                <div class="w-16 h-16 rounded-2xl bg-amber-50 group-hover:bg-amber-100 flex items-center justify-center mx-auto mb-4 transition-colors peer-checked:bg-amber-100">
                                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Pengaduan</h3>
                                <p class="text-sm text-gray-500">Laporkan masalah yang membutuhkan penanganan segera.</p>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="jenis_laporan" value="aspirasi" x-model="form.jenis" class="hidden peer">
                            <div class="bg-white rounded-2xl p-8 border-2 border-gray-100 peer-checked:border-secondary-500 peer-checked:bg-secondary-50/50 hover-lift transition-all text-center peer-checked:shadow-lg">
                                <div class="w-16 h-16 rounded-2xl bg-secondary-50 group-hover:bg-secondary-100 flex items-center justify-center mx-auto mb-4 transition-colors">
                                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Aspirasi</h3>
                                <p class="text-sm text-gray-500">Sampaikan ide, saran, atau usulan untuk perbaikan.</p>
                            </div>
                        </label>
                    </div>
                    <p x-show="errors.jenis" class="text-red-500 text-sm text-center mt-4" x-text="errors.jenis"></p>
                </div>

                {{-- STEP 2: Kategori --}}
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Pilih Kategori</h2>
                        <p class="text-gray-500">Kategori mana yang sesuai dengan laporan Anda?</p>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <template x-for="cat in categories" :key="cat.value">
                            <label class="cursor-pointer group">
                                <input type="radio" name="kategori" :value="cat.value" x-model="form.kategori" class="hidden peer">
                                <div class="bg-white rounded-2xl p-6 border-2 border-gray-100 peer-checked:border-primary-500 peer-checked:bg-primary-50/30 hover-lift transition-all flex items-start gap-4 peer-checked:shadow-md">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors" :class="cat.bgColor">
                                        <span class="text-2xl" x-text="cat.icon"></span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-sm" x-text="cat.label"></h3>
                                        <p class="text-xs text-gray-500 mt-1" x-text="cat.desc"></p>
                                    </div>
                                </div>
                            </label>
                        </template>
                    </div>
                    <p x-show="errors.kategori" class="text-red-500 text-sm text-center mt-4" x-text="errors.kategori"></p>
                </div>

                {{-- STEP 3: Detail --}}
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Detail Laporan</h2>
                        <p class="text-gray-500">Jelaskan laporan Anda selengkap mungkin.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-5">
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-1.5">Judul Laporan <span class="text-red-500">*</span></label>
                            <input type="text" id="judul" name="judul" x-model="form.judul" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all outline-none"
                                   placeholder="Ringkasan singkat masalah/aspirasi Anda">
                            <p x-show="errors.judul" class="text-red-500 text-xs mt-1" x-text="errors.judul"></p>
                        </div>
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                            <textarea id="deskripsi" name="deskripsi" rows="5" x-model="form.deskripsi" required
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all outline-none resize-none"
                                      placeholder="Jelaskan detail laporan Anda..."></textarea>
                            <p x-show="errors.deskripsi" class="text-red-500 text-xs mt-1" x-text="errors.deskripsi"></p>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
                                <select id="kecamatan" name="kecamatan" x-model="form.kecamatan" @change="form.desa = ''"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all outline-none">
                                    <option value="">— Pilih Kecamatan —</option>
                                    <template x-for="kec in Object.keys(wilayah)" :key="kec">
                                        <option :value="kec" x-text="kec"></option>
                                    </template>
                                </select>
                                <p x-show="errors.kecamatan" class="text-red-500 text-xs mt-1" x-text="errors.kecamatan"></p>
                            </div>
                            <div>
                                <label for="desa" class="block text-sm font-medium text-gray-700 mb-1.5">Desa/Kelurahan <span class="text-red-500">*</span></label>
                                <select id="desa" name="desa" x-model="form.desa" :disabled="!form.kecamatan"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                                    <option value="">— Pilih Desa —</option>
                                    <template x-for="d in (wilayah[form.kecamatan] || [])" :key="d">
                                        <option :value="d" x-text="d"></option>
                                    </template>
                                </select>
                                <p x-show="errors.desa" class="text-red-500 text-xs mt-1" x-text="errors.desa"></p>
                            </div>
                        </div>
                        <div>
                            <label for="detail_alamat" class="block text-sm font-medium text-gray-700 mb-1.5">Detail Alamat <span class="text-gray-400">(opsional)</span></label>
                            <textarea id="detail_alamat" name="detail_alamat" rows="2" x-model="form.detail_alamat"
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all outline-none resize-none"
                                      placeholder="Contoh: Depan SD Negeri 1, jalan masuk ke pasar..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Bukti <span class="text-gray-400">(opsional, maks 3)</span></label>
                            <div class="dropzone rounded-xl p-6 text-center cursor-pointer" @click="$refs.fileInput.click()" @dragover.prevent="$el.classList.add('dragover')" @dragleave.prevent="$el.classList.remove('dragover')" @drop.prevent="handleDrop($event)">
                                <input type="file" name="foto[]" multiple accept="image/*" class="hidden" x-ref="fileInput" @change="handleFiles($event)">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm text-gray-500">Klik atau seret foto ke sini</p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG — maks 2MB per file</p>
                            </div>
                            <div x-show="previews.length > 0" class="flex gap-3 mt-3 flex-wrap">
                                <template x-for="(preview, i) in previews" :key="i">
                                    <div class="relative w-20 h-20 rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                        <img :src="preview" class="w-full h-full object-cover">
                                        <button type="button" @click="removeFile(i)" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">×</button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STEP 4: Konfirmasi --}}
                <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Konfirmasi Laporan</h2>
                        <p class="text-gray-500">Periksa kembali data laporan Anda.</p>
                    </div>
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-sm space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Jenis Laporan</span>
                            <span class="text-sm font-semibold capitalize" :class="form.jenis === 'pengaduan' ? 'text-amber-600' : 'text-secondary-600'" x-text="form.jenis || '-'"></span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Kategori</span>
                            <span class="text-sm font-semibold text-gray-900" x-text="getCategoryLabel(form.kategori)"></span>
                        </div>
                        <div class="py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Judul</span>
                            <p class="text-sm font-semibold text-gray-900 mt-1" x-text="form.judul || '-'"></p>
                        </div>
                        <div class="py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Deskripsi</span>
                            <p class="text-sm text-gray-700 mt-1 whitespace-pre-line" x-text="form.deskripsi || '-'"></p>
                        </div>
                        <div class="py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Lokasi</span>
                            <p class="text-sm font-semibold text-gray-900 mt-1">
                                <span x-text="form.desa || '-'"></span><span x-show="form.kecamatan">, </span><span x-text="form.kecamatan"></span>
                            </p>
                            <p x-show="form.detail_alamat" class="text-xs text-gray-500 mt-0.5" x-text="form.detail_alamat"></p>
                        </div>
                        <div x-show="previews.length > 0" class="py-3">
                            <span class="text-sm text-gray-500">Foto Bukti</span>
                            <div class="flex gap-3 mt-2 flex-wrap">
                                <template x-for="(preview, i) in previews" :key="i">
                                    <div class="w-20 h-20 rounded-xl overflow-hidden border border-gray-200"><img :src="preview" class="w-full h-full object-cover"></div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <div class="flex justify-between mt-8">
                    <button type="button" x-show="currentStep > 0" @click="prevStep()" class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        ← Kembali
                    </button>
                    <div x-show="currentStep === 0"></div>
                    <button type="button" x-show="currentStep < 3" @click="nextStep()" class="px-8 py-3 text-sm font-semibold text-white gradient-hero rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Lanjut →
                    </button>
                    <button type="submit" x-show="currentStep === 3" class="px-8 py-3 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
    function wizardForm() {
        return {
            currentStep: 0,
            steps: ['Jenis', 'Kategori', 'Detail', 'Konfirmasi'],
            form: { jenis: '', kategori: '', judul: '', deskripsi: '', kecamatan: '', desa: '', detail_alamat: '' },
            errors: {},
            previews: [],
            files: [],
            wilayah: {
                "Wewewa Utara": ["Djela Manu","Mali Mada","Mata Loko","Mawo Maliti","Odi Paurata","Pandua Tana","Puu Potto","Reda Wano","Wano Talla","Wee Namba","Wee Paboba"],
                "Wewewa Timur": ["Dangga Mangu","Dede Pada","Dikira","Kadi Wano","Kadi Wone","Kalembu Ndara Mane","Lele Maya","Lete Kamouna","Mainda Ole","Maliti Dari","Mareda Kalada","Mata Pyawu","Mata Wee Lima","Mawo Dana","Nyura Lele","Pada Eweta","Tema Tana","Wee Lima","Wee Limbu"],
                "Wewewa Tengah": ["Bolora","Bondo Delo","Eka Pata","Gollu Sapi","Kadi Roma","Kalingara","Kanelu","Kiku Booko","Lete Wungana","Limbu Watu","Lombu","Mata Lombu","Mata Wee Karoro","Mereda Wuni","Omba Rade","Tanggaba","Tara Mata","Wee Kokora","Wee Patando","Wee Rame"],
                "Wewewa Selatan": ["Bondo Bela","Bondo Ukka","Buru Deilo","Buru Kaghu","Delo","Denduka","Mandungo","Milla Ate","Rita Baru","Tena Teke","Umbu Wangu","Wee Baghe","Wee Wulla","Weri Lolo"],
                "Wewewa Barat": ["Kabali Dana","Kalaki Kambe","Kalembu Kanaika","Kalembu Weri","Kalimbu Tillu","Laga Lete","Lolo Ole","Lua Koba","Marokota","Menne Ate","Pero","Raba Ege","Reda Pada","Sangu Ate","Tawo Rara","Waimangura","Wali Ate","Watu Labara","Wee Kombaka","Wee Kura"],
                "Loura": ["Bondo Boghila","Karuni","Lete Konda","Lete Konda Selatan","Loko Kalada","Payola Umbu","Pogo Tena","Rama Dana","Totok","Wee Kambala","Wee Mananda"],
                "Kota Tambolaka": ["Kadi Pada","Kalembu Kaha","Kalena Wano","Langga Lero","Rada Mata","Waitabula","Watu Kawula","Wee Londa","Wee Pangali","Wee Rena"],
                "Kodi Utara": ["Bila Cenge","Bukambero","Hameli Ate","Hoha Wungo","Homba Karipit","Homba Pare","Kadaghu Tana","Kadu Eta","Kalena Rongo","Kendu Wela","Kori","Limbu Kemba","Magho Linyo","Mangganipi","Moro Manduyo","Nanggamut","Noha","Waiholo","Wailabubur","Waitaru","Wee Wella"],
                "Kodi Bangedo": ["Ana Goka","Ana Lewe","Bondo Balla","Dilu Depa","Dinjo","Karang Indah","Lete Loko","Maliti Bondo Ate","Manu Toghi","Mata Kapore","Mere Kehe","Rada Loko","Rada Malando","Tana Mete","Umbu Ngedo","Waikadada","Waikaninyo","Waimakaha","Waimaringi","Waipaddi","Walla Ndimu"],
                "Kodi Balaghar": ["Kahale","Loko Tali","Panenggo Ede","Waiha","Waikarara","Wailangira","Wainyapu","Waipakolo"],
                "Kodi": ["Ana Engge","Ana Kaka","Ate Dalo","Bondo Kodi","Hamonggo Lele","Homba Rande","Homba Rica","Kadoki Horo","Kapaka Madeta","Kawango Hari","Koki","Mali Iha","Ole Ate","Onggol","Pero Batang","Pero Konda","Tanjung Karoso","Watu Wona","Wura Homba"]
            },
            categories: [
                { value: 'infrastruktur_jaringan', label: 'Infrastruktur Jaringan', desc: 'Internet, BTS, WiFi publik', icon: '🌐', bgColor: 'bg-blue-50' },
                { value: 'layanan_digital', label: 'Layanan Digital Pemerintah', desc: 'Website/aplikasi error', icon: '🖥️', bgColor: 'bg-violet-50' },
                { value: 'hoaks', label: 'Hoaks / Konten Negatif', desc: 'Berita bohong, konten negatif', icon: '🚫', bgColor: 'bg-red-50' },
                { value: 'data_sistem', label: 'Data & Sistem Digital', desc: 'Error data, sistem bermasalah', icon: '🗄️', bgColor: 'bg-emerald-50' },
            ],
            nextStep() {
                this.errors = {};
                if (this.currentStep === 0 && !this.form.jenis) { this.errors.jenis = 'Pilih jenis laporan terlebih dahulu.'; return; }
                if (this.currentStep === 1 && !this.form.kategori) { this.errors.kategori = 'Pilih kategori terlebih dahulu.'; return; }
                if (this.currentStep === 2) {
                    if (!this.form.judul.trim()) { this.errors.judul = 'Judul wajib diisi.'; return; }
                    if (!this.form.deskripsi.trim()) { this.errors.deskripsi = 'Deskripsi wajib diisi.'; return; }
                    if (!this.form.kecamatan) { this.errors.kecamatan = 'Pilih kecamatan.'; return; }
                    if (!this.form.desa) { this.errors.desa = 'Pilih desa.'; return; }
                }
                this.currentStep++;
            },
            prevStep() { this.currentStep--; },
            getCategoryLabel(val) {
                const cat = this.categories.find(c => c.value === val);
                return cat ? cat.label : '-';
            },
            handleFiles(event) {
                const newFiles = Array.from(event.target.files).slice(0, 3 - this.files.length);
                newFiles.forEach(file => {
                    this.files.push(file);
                    const reader = new FileReader();
                    reader.onload = (e) => this.previews.push(e.target.result);
                    reader.readAsDataURL(file);
                });
            },
            handleDrop(event) {
                event.target.closest('.dropzone').classList.remove('dragover');
                const newFiles = Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/')).slice(0, 3 - this.files.length);
                newFiles.forEach(file => {
                    this.files.push(file);
                    const reader = new FileReader();
                    reader.onload = (e) => this.previews.push(e.target.result);
                    reader.readAsDataURL(file);
                });
            },
            removeFile(index) { this.files.splice(index, 1); this.previews.splice(index, 1); }
        }
    }
    </script>
</x-layouts.app>
