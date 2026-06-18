const fs = require('fs');
const path = require('path');

const controllersDir = '/Users/bbs/Documents/Project/hotline-dashboard/app/Http/Controllers';
const viewsDir = '/Users/bbs/Documents/Project/hotline-dashboard/resources/views/Admin';

const services = [
    { c: 'BandwidthOnDemandController.php', v: 'bandwidth-on-demand.blade.php' },
    { c: 'InfrastrukturController.php', v: 'infrastruktur-baru.blade.php' },
    { c: 'PentestingController.php', v: 'pentesting.blade.php' },
    { c: 'ResetEmailController.php', v: 'reset-email.blade.php' },
    { c: 'TandaTanganElektronikController.php', v: 'tanda-tangan-elektronik.blade.php' },
    { c: 'VirtualMeetingController.php', v: 'virtual-meeting.blade.php' },
    { c: 'VirtualPrivateServerController.php', v: 'virtual-private-server.blade.php' }
];

services.forEach(s => {
    // 1. Update Controller
    let cPath = path.join(controllersDir, s.c);
    let cContent = fs.readFileSync(cPath, 'utf8');
    
    let varName;
    cContent = cContent.replace(/\$([a-zA-Z0-9_]+)\s*=\s*([a-zA-Z0-9_]+)::all\(\);/, (match, v, m) => {
        varName = v;
        return `
        $query = \\App\\Models\\${m}::query();
        if (request()->has('search') && request()->search != '') {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }
        if (request()->has('status') && request()->status != '') {
            $query->where('status', request()->status);
        }
        $${v} = $query->latest()->paginate(10);`;
    });
    fs.writeFileSync(cPath, cContent);
    console.log('Updated controller', s.c, 'using var', varName);

    // 2. Update View
    if (varName) {
        let vPath = path.join(viewsDir, s.v);
        let vContent = fs.readFileSync(vPath, 'utf8');

        // Check if already has filter card
        if (!vContent.includes('id="searchInput"')) {
            vContent = vContent.replace(/<\/div>\s*<div class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">/, `</div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 p-4 mb-6" id="filter-card">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative w-full md:w-64">
          <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
          <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari tiket atau nama..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
      </div>
      <div class="flex items-center gap-2 w-full md:w-auto">
        <select id="statusFilter" class="w-full md:w-48 px-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
          <option value="">Semua Status</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Open</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Selesai</option>
        </select>
      </div>
    </div>
  </div>

  <div id="table-container" class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">`);

            // Add Pagination block and fix aduanData reference
            vContent = vContent.replace(/<\/table>\s*<\/div>\s*<\/div>/, `</table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
      {{ $${varName}->appends(request()->query())->links() }}
    </div>
  </div>`);

            fs.writeFileSync(vPath, vContent);
            console.log('Updated view', s.v);
        }
    }
});

// Also manually fix aduan-layanan.blade.php
let aduanPath = path.join(viewsDir, 'aduan-layanan.blade.php');
let aduanContent = fs.readFileSync(aduanPath, 'utf8');
if (!aduanContent.includes('id="searchInput"')) {
    aduanContent = aduanContent.replace(/<\/div>\s*<div class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">/, `</div>

  <div class="bg-white rounded-box shadow-soft border border-slate-200 p-4 mb-6" id="filter-card">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div class="flex items-center gap-2 w-full md:w-auto">
        <div class="relative w-full md:w-64">
          <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
          <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari tiket atau nama..." class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-shadow">
        </div>
      </div>
      <div class="flex items-center gap-2 w-full md:w-auto">
        <select id="statusFilter" class="w-full md:w-48 px-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white">
          <option value="">Semua Status</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Open</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Selesai</option>
        </select>
      </div>
    </div>
  </div>

  <div id="table-container" class="bg-white rounded-box shadow-soft border border-slate-200 overflow-hidden">`);

    aduanContent = aduanContent.replace(/<\/table>\s*<\/div>\s*<\/div>/, `</table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
      {{ $aduan->appends(request()->query())->links() }}
    </div>
  </div>`);
    
    fs.writeFileSync(aduanPath, aduanContent);
    console.log('Updated aduan-layanan.blade.php');
}
