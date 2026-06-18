const fs = require('fs');
const path = require('path');

const dir = '/Users/bbs/Documents/Project/hotline-dashboard/resources/views/Admin';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php') && f !== 'dash.blade.php' && f !== 'rekap.blade.php' && f !== 'pengguna.blade.php');

files.forEach(file => {
    let content = fs.readFileSync(path.join(dir, file), 'utf8');
    
    // Change wrapper
    content = content.replace('<div class="overflow-x-auto">', '<div class="p-5 overflow-x-auto">');
    content = content.replace('<table>', '<table class="w-full text-left border-collapse data-table">');
    
    // Change all <th> to have the long class
    content = content.replace(/<th>/g, '<th class="px-5 py-3 border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-wider">');
    
    // Since we now use the global datatable, remove any extra DataTables CSS/JS if they exist (though they shouldn't in these files).
    
    fs.writeFileSync(path.join(dir, file), content);
    console.log('Fixed', file);
});
