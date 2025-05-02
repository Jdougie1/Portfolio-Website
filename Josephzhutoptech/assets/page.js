document.addEventListener('DOMContentLoaded', ()=> {
    const cover   = document.getElementById('cover');
    const flow    = document.getElementById('flow');
    const pages   = [...document.querySelectorAll('.flow-page')];
    let idx       = 0;
    const beginBtn = document.getElementById('beginBtn');
    const nextBtn  = document.getElementById('nextBtn');
    const backBtn  = document.getElementById('backBtn');
    const addBtn   = document.getElementById('addExpBtn');
    const modal    = document.getElementById('expModal');
    const cancel   = document.getElementById('cancelExp');
    const form     = document.getElementById('expForm');
    const list     = document.getElementById('expList');
  
    beginBtn.onclick = () => {
      cover.classList.add('hidden');
      flow.classList.remove('hidden');
    };
    nextBtn.onclick = () => nav(1);
    backBtn.onclick = () => nav(-1);
  
    function nav(dir) {
      pages[idx].classList.add('hidden');
      idx = Math.max(0, Math.min(pages.length-1, idx+dir));
      pages[idx].classList.remove('hidden');
      backBtn.disabled = idx===0;
      nextBtn.disabled = idx===pages.length-1;
      if (idx===1) loadExps();
    }
  
    addBtn.onclick = ()=> modal.classList.remove('hidden');
    cancel.onclick = ()=> { form.reset(); modal.classList.add('hidden'); };
  
    function loadExps() {
      list.innerHTML = '';
      fetch('api/list_autofill.php')
        .then(r=>r.json()).then(data=>{
          fillDL('titles', data.titles);
          fillDL('companies', data.companies);
          data.exps.forEach(e=>{
            const li = document.createElement('li');
            li.innerHTML = `<strong>${e.title}</strong> @ ${e.company}
              <p>${e.start_date} → ${e.end_date||'Present'}</p>
              <p>${e.description}</p>`;
            list.appendChild(li);
          });
        });
    }
    function fillDL(id, items) {
      let dl = document.getElementById(id);
      if (!dl) {
        dl = document.createElement('datalist');
        dl.id = id;
        document.body.appendChild(dl);
      }
      dl.innerHTML = items.map(v=>`<option value="${v}">`).join('');
    }
  
    form.addEventListener('submit', e=>{
      e.preventDefault();
      fetch('api/add_experience.php', {
        method:'POST',
        body:new FormData(form)
      })
      .then(r=>r.json()).then(res=>{
        if (res.success) {
          form.reset();
          modal.classList.add('hidden');
          loadExps();
        } else alert('Save failed');
      });
    });
  
    // Theme toggle
    const toggle = document.getElementById('themeToggle');
    const saved  = localStorage.getItem('theme')||'light';
    document.documentElement.setAttribute('data-theme', saved);
    toggle.textContent = saved==='dark'?'☀️':'🌙';
    toggle.onclick = ()=>{
      const next = document.documentElement.getAttribute('data-theme')==='light'
        ?'dark':'light';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('theme', next);
      toggle.textContent = next==='dark'?'☀️':'🌙';
    };
  });
  