<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manojkumar Chinnasamy · resume (alternate design)</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #e9edf2;
      font-family: 'Inter', 'Segoe UI', Roboto, system-ui, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem 1rem;
      line-height: 1.5;
    }

    .card {
      max-width: 980px;
      width: 100%;
      background: #ffffff;
      border-radius: 32px;
      box-shadow: 0 30px 50px -20px rgba(0, 30, 60, 0.25);
      overflow: hidden;
      transition: all 0.2s;
    }

    /* top banner / profile strip */
    .banner {
      background: #0c2b3c;
      padding: 2rem 2.5rem 1.5rem 2.5rem;
      color: white;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: flex-end;
    }

    .name-title h1 {
      font-size: 2.8rem;
      font-weight: 600;
      letter-spacing: -0.02em;
      line-height: 1.1;
      color: white;
      margin-bottom: 0.25rem;
    }

    .name-title .role {
      font-size: 1.25rem;
      font-weight: 400;
      color: #aaccdd;
      border-left: 4px solid #ffb347;
      padding-left: 1rem;
      margin-top: 0.4rem;
    }

    .quick-contact {
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(6px);
      padding: 0.8rem 1.6rem;
      border-radius: 60px;
      font-size: 0.95rem;
      border: 1px solid rgba(255,255,255,0.15);
      display: flex;
      flex-wrap: wrap;
      gap: 1.2rem 2rem;
      margin-top: 1rem;
    }

    .quick-contact span, .quick-contact a {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: white;
      text-decoration: none;
      font-weight: 400;
    }

    .quick-contact a:hover {
      text-decoration: underline;
      color: #ffd966;
    }

    /* main grid: two columns with subtle contrast */
    .columns {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 0;
      background: #fff;
    }

    /* left panel – light slate */
    .left-panel {
      background: #f3f7fb;
      padding: 2rem 2rem 2.5rem 2rem;
      border-right: 1px solid #dbe4ed;
    }

    .right-panel {
      background: white;
      padding: 2rem 2.2rem 2.5rem 2.2rem;
    }

    .block {
      margin-bottom: 2.2rem;
    }

    .block-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 1rem;
      border-bottom: 2px solid rgba(12, 43, 60, 0.15);
      padding-bottom: 0.4rem;
    }

    .block-header .icon {
      font-size: 1.4rem;
      line-height: 1;
    }

    .block-header h3 {
      font-size: 1.2rem;
      font-weight: 600;
      color: #0c2b3c;
      letter-spacing: 0.3px;
      text-transform: uppercase;
    }

    /* skill chips */
    .skill-cloud {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }

    .chip {
      background: white;
      border: 1px solid #bfd6e7;
      padding: 0.3rem 1.2rem;
      border-radius: 40px;
      font-size: 0.85rem;
      font-weight: 500;
      color: #0b3a4b;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
      transition: 0.1s;
    }

    .chip.accent {
      background: #0c2b3c;
      border-color: #0c2b3c;
      color: white;
    }

    .chip.orange-border {
      border-left: 3px solid #ff9f4b;
    }

    .list-item {
      margin-bottom: 0.8rem;
    }

    .list-item .title-sm {
      font-weight: 600;
      color: #0f4057;
      display: block;
      font-size: 0.95rem;
    }

    .list-item .sub {
      font-size: 0.9rem;
      color: #3c5a6b;
    }

    .edu-line {
      margin-bottom: 0.9rem;
    }

    .edu-line .deg {
      font-weight: 600;
      color: #0b2b3f;
    }

    .edu-line .place {
      font-size: 0.9rem;
      color: #2f4d5e;
    }

    .edu-line .year {
      display: inline-block;
      background: #e3eef5;
      padding: 0.2rem 1rem;
      border-radius: 30px;
      font-size: 0.8rem;
      font-weight: 500;
      margin-top: 0.2rem;
    }

    /* right panel blocks */
    .exp-item, .project-item {
      margin-bottom: 1.8rem;
    }

    .exp-head {
      display: flex;
      flex-wrap: wrap;
      align-items: baseline;
      justify-content: space-between;
      margin-bottom: 0.2rem;
    }

    .exp-head .org {
      font-weight: 700;
      font-size: 1.1rem;
      color: #0c2b3c;
    }

    .exp-head .role {
      font-weight: 600;
      color: #c96b1c;
      margin-right: 15px;
    }

    .exp-head .date {
      background: #edf4f9;
      padding: 0.2rem 1.2rem;
      border-radius: 30px;
      font-size: 0.8rem;
      font-weight: 600;
      color: #1b5470;
    }

    .exp-desc {
      margin-top: 0.6rem;
      padding-left: 0.2rem;
    }

    .exp-desc li {
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
      display: flex;
      gap: 10px;
    }

    .exp-desc li::before {
      content: "?";
      color: #c96b1c;
      font-size: 0.7rem;
      margin-right: 4px;
      transform: translateY(3px);
    }

    .project-item {
      border-left: 4px solid transparent;
      background: #f9fcff;
      padding: 0.8rem 1rem;
      border-radius: 0 16px 16px 0;
      transition: 0.1s;
      border-left-color: #1e7e9c;
    }

    .project-title {
      font-weight: 700;
      color: #154e65;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 8px;
    }

    .project-tag {
      background: #0c2b3c;
      color: white;
      font-size: 0.7rem;
      padding: 0.2rem 1rem;
      border-radius: 30px;
      letter-spacing: 0.3px;
    }

    .project-desc {
      margin-top: 0.25rem;
      font-size: 0.9rem;
      color: #1e4456;
    }

    hr {
      border: 0;
      border-top: 2px dotted #bed5e5;
      margin: 1rem 0;
    }

    .summary-card {
      background: #e7f0f7;
      border-radius: 24px;
      padding: 1.4rem 1.8rem;
      margin-bottom: 2rem;
      color: #0b2f40;
      font-size: 0.95rem;
      border: 1px solid #cde0ed;
      box-shadow: inset 0 1px 4px white;
    }

    @media (max-width: 750px) {
      .columns { grid-template-columns: 1fr; }
      .left-panel { border-right: 0; border-bottom: 2px solid #d4e0ea; }
      .banner { flex-direction: column; align-items: flex-start; }
    }
    @media print {
      body { background: white; }
      .card { box-shadow: none; border: 1px solid #aaa; }
    }
  </style>
</head>
<body>
<div class="card">
  <!-- top banner with name + contact chips -->
  <div class="banner">
    <div class="name-title">
      <h1>Manojkumar Chinnasamy</h1>
      <div class="role">Full-Stack Developer (5+ years)</div>
      <!-- quick contact inside banner for compactness -->
      <div class="quick-contact">
        <span>?? Erode, Tamil Nadu</span>
        <span>?? <a href="mailto:manojkumar31798@gmail.com">manojkumar31798@gmail.com</a></span>
        <span>?? 7904019293</span>
        <span>?? <a href="#">linkedin.com/in/manojkumar-chinnasamy</a></span>
      </div>
    </div>
  </div>

  <!-- main two columns -->
  <div class="columns">
    <!-- LEFT: skills, education, tools -->
    <div class="left-panel">
      
      <!-- skills block -->
      <div class="block">
        <div class="block-header">
          <span class="icon">??</span>
          <h3>Tech stack</h3>
        </div>
        <div class="skill-cloud">
          <span class="chip accent">PHP</span>
          <span class="chip accent">Laravel</span>
          <span class="chip">JavaScript</span>
          <span class="chip">MySQL</span>
          <span class="chip">jQuery</span>
          <span class="chip">AJAX</span>
          <span class="chip">HTML5/CSS3</span>
          <span class="chip">SQL</span>
          <span class="chip">XML</span>
          <span class="chip orange-border">RESTful API</span>
          <span class="chip">Postman</span>
          <span class="chip">Swagger</span>
          <span class="chip">Git</span>
          <span class="chip">Docker (basic)</span>
        </div>
      </div>

      <!-- developer tools & AI assistants -->
      <div class="block">
        <div class="block-header">
          <span class="icon">???</span>
          <h3>Tools & AI</h3>
        </div>
        <div class="skill-cloud">
          <span class="chip">VS Code</span>
          <span class="chip">Claude</span>
          <span class="chip">ChatGPT</span>
          <span class="chip">Gemini</span>
          <span class="chip">DeepSeek</span>
          <span class="chip">Motion Pro</span>
          <span class="chip">WinSCP</span>
          <span class="chip">PuTTY</span>
          <span class="chip">FortiClient</span>
        </div>
      </div>

      <!-- specialized areas -->
      <div class="block">
        <div class="block-header">
          <span class="icon">??</span>
          <h3>Specialties</h3>
        </div>
        <ul style="list-style: none; margin-left: 6px;">
          <li style="margin-bottom: 6px;">? Auth & encryption (JWT, OAuth)</li>
          <li style="margin-bottom: 6px;">? Data validation & sanitization</li>
          <li style="margin-bottom: 6px;">? Cron / Task scheduling</li>
          <li style="margin-bottom: 6px;">? Database triggers & events</li>
          <li style="margin-bottom: 6px;">? Debugging & manual testing</li>
        </ul>
      </div>

      <!-- education -->
      <div class="block">
        <div class="block-header">
          <span class="icon">??</span>
          <h3>Education</h3>
        </div>
        <div class="edu-line">
          <span class="deg">B.E. Computer Science & Engineering</span>
          <div class="place">JKKN College of Engineering & Technology</div>
          <span class="year">2015 – 2019 | 69%</span>
        </div>
        <div class="edu-line">
          <span class="deg">HSSC (12th)</span>
          <div class="place">Govt Higher Secondary School, Anthiyur</div>
          <span class="year">2015 | 75%</span>
        </div>
        <div class="edu-line">
          <span class="deg">SSLC (10th)</span>
          <div class="place">Govt Higher Secondary School, Anthiyur</div>
          <span class="year">2013 | 85%</span>
        </div>
      </div>
      
      <!-- additional: api dev -->
      <div class="block">
        <div class="block-header">
          <span class="icon">??</span>
          <h3>API & backend</h3>
        </div>
        <div class="skill-cloud">
          <span class="chip">RESTful design</span>
          <span class="chip">authentication</span>
          <span class="chip">validation</span>
          <span class="chip">encryption</span>
        </div>
      </div>
    </div>

    <!-- RIGHT: summary, experience, projects -->
    <div class="right-panel">
      <!-- summary card -->
      <div class="summary-card">
        <strong>?? Full-Stack Developer</strong> with 5+ years of experience in PHP/Laravel, MySQL, and JavaScript. Proven success in government projects (Adi Dravidar, Smart City, VOC Harbour) delivering secure, scalable modules. Strong focus on API integration, database optimisation, and clean code. Hands-on with modern AI tools to accelerate development.
      </div>

      <!-- experience -->
      <div class="block">
        <div class="block-header">
          <span class="icon">??</span>
          <h3>work history</h3>
        </div>

        <div class="exp-item">
          <div class="exp-head">
            <span class="org">Ascent E Digit Solution</span>
            <span class="role">Full-Stack Developer</span>
            <span class="date">Oct 2023 – present</span>
          </div>
          <ul class="exp-desc" style="list-style: none;">
            <li><strong>Adi Dravidar Govt project</strong> – hostel automation (registration, verification, biometric).</li>
            <li>Maintain multiple Core PHP/PDO projects with modular code & bug fixes.</li>
            <li><strong>Smart City Tiruppur (ICCC)</strong> – built SCADA, waste, streetlight & GPS modules.</li>
            <li>Task management web app – interactive tracking & reporting (PHP/AJAX).</li>
          </ul>
        </div>

        <div class="exp-item">
          <div class="exp-head">
            <span class="org">TNQ Technologies Pvt Ltd</span>
            <span class="role">Full-Stack Developer</span>
            <span class="date">Sep 2019 – Dec 2022</span>
          </div>
          <ul class="exp-desc" style="list-style: none;">
            <li>Designed and deployed Laravel/PHP applications with high performance.</li>
            <li>Built secure REST APIs, optimised MySQL queries (30% faster response).</li>
            <li>Collaborated on front-end interfaces (JavaScript, jQuery, AJAX).</li>
            <li>Ensured cross-platform stability & production reliability.</li>
          </ul>
        </div>
      </div>

      <!-- key projects (as feature cards) -->
      <div class="block">
        <div class="block-header">
          <span class="icon">??</span>
          <h3>key projects</h3>
        </div>

        <div class="project-item">
          <div class="project-title">
            Adi Dravidar & Tribal Welfare
            <span class="project-tag">govt</span>
          </div>
          <div class="project-desc">Digital student hostel management – registration, verification workflow, biometric attendance, dashboard.</div>
        </div>

        <div class="project-item">
          <div class="project-title">
            Smart City Tiruppur – ICCC
            <span class="project-tag">govt</span>
          </div>
          <div class="project-desc">Modules for SCADA, waste management, streetlight control, GPS; real-time data visualisation.</div>
        </div>

        <div class="project-item">
          <div class="project-title">
            VOC Harbour Central Port
            <span class="project-tag">govt</span>
          </div>
          <div class="project-desc">Secure import/export permit system with Laravel, role access, audit logs & encryption.</div>
        </div>

        <div class="project-item">
          <div class="project-title">VCET Waste Management</div>
          <div class="project-desc">Bug fixing & enhancement for enterprise waste tracking (PHP, AJAX).</div>
        </div>

        <div class="project-item">
          <div class="project-title">Task Management Application</div>
          <div class="project-desc">Task assignment, real-time status, reporting dashboards (PHP, AJAX, MySQL).</div>
        </div>
      </div>

      <!-- small callout: cron / triggers etc. -->
      <hr>
      <div style="font-size:0.85rem; color:#2d6073; display:flex; gap: 16px; flex-wrap: wrap;">
        <span>? Cron jobs · Task scheduler</span>
        <span>? DB triggers · Events</span>
        <span>? Debugging & profiling</span>
      </div>
    </div>
  </div>
  <!-- tiny footer (optional) -->
  <div style="background:#f0f6fc; text-align:center; font-size:0.8rem; padding:0.8rem; color:#4c687a; border-top:1px solid #cee0ed;">
    Manojkumar Chinnasamy · Full-Stack Developer · 5+ years · available for opportunities
  </div>
</div>
</body>
</html>
