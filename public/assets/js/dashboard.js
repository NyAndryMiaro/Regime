// Minimal chart rendering without external libs
document.addEventListener('DOMContentLoaded', function(){
  initCharts();
});

function initCharts(){
  // weightChart - simple line
  const weightEl = document.getElementById('weightChart');
  if(weightEl && weightEl.getContext){
    const ctx = weightEl.getContext('2d');
    drawLineChart(ctx, ['1','5','10','15','20','25','30'], [68,67.5,67,66.5,66,65.5,65]);
  }

  // caloriesChart - bar
  const caloriesEl = document.getElementById('caloriesChart');
  if(caloriesEl && caloriesEl.getContext){
    const ctx2 = caloriesEl.getContext('2d');
    drawBarChart(ctx2, ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'], [2150,2300,2100,2250,2200,2400,2100]);
  }

  // nutritionChart - doughnut (approx)
  const nutritionEl = document.getElementById('nutritionChart');
  if(nutritionEl && nutritionEl.getContext){
    const ctx3 = nutritionEl.getContext('2d');
    drawDoughnut(ctx3, [50,30,20], ['#10b981','#059669','#d1fae5']);
  }

  // hydrationChart - radar simplified as area
  const hydrationEl = document.getElementById('hydrationChart');
  if(hydrationEl && hydrationEl.getContext){
    const ctx4 = hydrationEl.getContext('2d');
    drawLineChart(ctx4, ['L','M','M','J','V','S','D'], [2.2,2.5,2.1,2.4,2.6,2.3,2.1], {fill:true, color:'#10b981'});
  }

  // Admin charts (if present)
  const genderEl = document.getElementById('genderChart');
  if(genderEl && genderEl.getContext){
    const ctx5 = genderEl.getContext('2d');
    // read counts from data attribute if provided, else dummy
    const dataset = window.__genderData || [3,4];
    drawDoughnut(ctx5, dataset, ['#10b981','#059669']);
  }

  const weightDistEl = document.getElementById('weightDistributionChart');
  if(weightDistEl && weightDistEl.getContext){
    const ctx6 = weightDistEl.getContext('2d');
    const data = window.__weightDist || [1,3,2,0,0];
    drawBarChart(ctx6, ['<60','60-70','70-80','80-90','>90'], data, '#10b981');
  }

  const heightEl = document.getElementById('heightDistributionChart');
  if(heightEl && heightEl.getContext){
    drawBarChart(heightEl.getContext('2d'), ['<150','150-160','160-170','170-180','>180'], window.__heightDist || [0,2,4,1,0], '#6366f1');
  }

  const imcEl = document.getElementById('imcChart');
  if(imcEl && imcEl.getContext){
    const list = window.__imcData || [22,24,26,23,28];
    drawScatter(imcEl.getContext('2d'), list);
  }
}

function clearCanvas(ctx){
  const c = ctx.canvas; ctx.clearRect(0,0,c.width,c.height);
}

function fitCanvas(canvas){
  const ratio = window.devicePixelRatio || 1;
  const w = canvas.clientWidth || 300;
  const h = canvas.clientHeight || 200;
  canvas.width = w * ratio;
  canvas.height = h * ratio;
  const ctx = canvas.getContext('2d'); ctx.setTransform(ratio,0,0,ratio,0,0);
  return ctx;
}

function drawLineChart(ctx, labels, data, opts){
  const canvasCtx = fitCanvas(ctx.canvas);
  clearCanvas(canvasCtx);
  const w = ctx.canvas.clientWidth || 300; const h = ctx.canvas.clientHeight || 200;
  const padding = 30;
  const max = Math.max.apply(null, data);
  const min = Math.min.apply(null, data);
  const range = (max - min) || 1;
  // draw grid
  canvasCtx.strokeStyle = '#e6f0ea'; canvasCtx.lineWidth = 1;
  for(let i=0;i<=4;i++){ let y = padding + (h-2*padding) * (i/4); canvasCtx.beginPath(); canvasCtx.moveTo(padding,y); canvasCtx.lineTo(w-padding,y); canvasCtx.stroke(); }
  // plot
  canvasCtx.strokeStyle = opts && opts.color ? opts.color : '#10b981';
  canvasCtx.lineWidth = 2; canvasCtx.beginPath();
  data.forEach((v,i)=>{
    const x = padding + (i/(data.length-1 || 1)) * (w-2*padding);
    const y = padding + (1 - (v-min)/range)*(h-2*padding);
    if(i===0) canvasCtx.moveTo(x,y); else canvasCtx.lineTo(x,y);
  });
  canvasCtx.stroke();
  if(opts && opts.fill){ canvasCtx.globalAlpha = 0.12; canvasCtx.lineTo(w-padding,h-padding); canvasCtx.lineTo(padding,h-padding); canvasCtx.closePath(); canvasCtx.fillStyle = opts.color || '#10b981'; canvasCtx.fill(); canvasCtx.globalAlpha = 1; }
}

function drawBarChart(ctx, labels, data, color){
  const canvasCtx = fitCanvas(ctx.canvas || ctx);
  clearCanvas(canvasCtx);
  const c = canvasCtx.canvas; const w = c.clientWidth||300; const h = c.clientHeight||200; const padding=30;
  const max = Math.max.apply(null, data);
  const bw = (w-2*padding)/data.length*0.7;
  data.forEach((v,i)=>{
    const x = padding + i*((w-2*padding)/data.length) + ((w-2*padding)/data.length - bw)/2;
    const height = (v/max) * (h-2*padding);
    canvasCtx.fillStyle = color || '#10b981';
    canvasCtx.fillRect(x, h-padding-height, bw, height);
  });
}

function drawDoughnut(ctx, values, colors){
  const canvasCtx = fitCanvas(ctx.canvas);
  clearCanvas(canvasCtx);
  const c = canvasCtx.canvas; const w=c.clientWidth||200; const h=c.clientHeight||200; const cx=w/2; const cy=h/2; const r=Math.min(w,h)/3;
  const total = values.reduce((a,b)=>a+b,0)||1; let start= -Math.PI/2;
  values.forEach((v,i)=>{ const ang = (v/total)*Math.PI*2; canvasCtx.beginPath(); canvasCtx.moveTo(cx,cy); canvasCtx.fillStyle = colors[i]||'#ccc'; canvasCtx.arc(cx,cy,r,start,start+ang); canvasCtx.lineTo(cx,cy); canvasCtx.fill(); start += ang; });
  // inner cutout
  canvasCtx.beginPath(); canvasCtx.fillStyle = '#fff'; canvasCtx.arc(cx,cy,r*0.55,0,Math.PI*2); canvasCtx.fill();
}

function drawScatter(ctx, values){
  const canvasCtx = fitCanvas(ctx.canvas);
  clearCanvas(canvasCtx);
  const c = canvasCtx.canvas; const w=c.clientWidth||300; const h=c.clientHeight||200; const padding=30;
  const max = Math.max.apply(null, values);
  values.forEach((v,i)=>{ const x = padding + (i/(values.length-1||1))*(w-2*padding); const y = padding + (1-(v/max))*(h-2*padding); canvasCtx.fillStyle='#f59e0b'; canvasCtx.beginPath(); canvasCtx.arc(x,y,4,0,Math.PI*2); canvasCtx.fill(); });
}
