<?php
include "db_connect.php";

$query = mysqli_query($conn,
"SELECT * FROM chapters WHERE subject='Dsa'"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body { background: #f0f4fc; }

        header {
            background: #1f3f98;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
        }

        .icons i { font-size: 24px; margin-left: 20px; cursor: pointer; }
        .icons i:hover { transform: scale(1.1); transition: 0.2s; }
        .logo img { height: 60px; width: auto; }

        .container {
            display: grid;
            grid-template-columns: 240px 1fr 600px;
            min-height: calc(100vh - 90px);
        }

        .sidebar {
            background: #eef3fb;
            padding: 20px;
            border-right: 1px solid #d8e4f5;
        }

        .sidebar h2 {
            margin-bottom: 16px;
            font-size: 15px;
            cursor: pointer;
            color: black;
        }

        .sidebar h2:hover { opacity: 0.7; }

        .add-btn {
            width: 100%;
            padding: 9px;
            margin-bottom: 18px;
            border: none;
            background: #1f3f98;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .add-btn:hover { background: #16317a; }

        .chapter { margin-bottom: 14px; }

        .chapter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 9px 12px;
            background: #d7ebff;
            border-radius: 6px;
            margin-bottom: 4px;
            font-size: 14px;
            font-weight: 600;
        }

        .chapter-header:hover { background: #c7e2ff; }
        .chapter-header i { transition: 0.3s; }
        .chapter.active .chapter-header i.fa-chevron-down { transform: rotate(180deg); }

        .chapter-content {
            list-style: none;
            padding-left: 8px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .chapter.active .chapter-content { max-height: 500px; }

        .chapter-content li {
            padding: 7px 10px;
            background: #eef6ff;
            margin-bottom: 4px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .chapter-content li:hover { background: #dbeeff; }
        .chapter-content li.active-topic { background: #bfdfff; color: black; }

        .content {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background: white;
        }

        .video-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
        }

        .video-placeholder {
            color: #bbb;
            font-size: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .video-placeholder i { font-size: 48px; }

        .notes-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            background: white;
            height: 350px;
            width: 80%;
        }

        .notes-header {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            background: white;
            font-weight: 600;
        }

        .notes-content {
            padding: 16px;
            line-height: 1.8;
            min-height: 80px;
        }

        .notes-content a {
            color: #1f3f98;
            text-decoration: underline;
            word-break: break-all;
        }

        .right-panel {
            background: #ffffff;
            border-left: 1px solid #ffffff;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .tutorial-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            background: white;
            width: 100%;
            height: 715px;
            min-height: 150px;
        }

        .tutorial-card h3 {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            background: white;
            font-weight: 600;
            font-size: 17px;
        }

        .tutorial-card a {
            display: flex;
            justify-content: space-between;
            text-decoration: none;
            color: #1f3f98;
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        .tutorial-card a:hover { background: #f5f5f5; }

        .placeholder-text { color: #aaa; font-size: 13px; }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="images/logoRakan.png" alt="Rakan Akademik Logo">
        <img src="images/logoUtem.png" alt="UTeM Logo">
        <img src="images/logoFtmk.png" alt="FTMK Logo">
    </div>
    <div class="icons">
        <i class="fas fa-home" onclick="location.href='dashboard.php'"></i>
        <i class="far fa-user-circle" onclick="location.href='profile.php'"></i>
    </div>
</header>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2 onclick="location.href='subjects.php'">
            <i class="fas fa-arrow-left" style="font-size:18px;"></i> DSA
        </h2>

        <button class="add-btn" onclick="location.href='addChapter.php?subject=Dsa'">
            <i class="fas fa-plus"></i> Add Chapter
        </button>

        <?php while($row = mysqli_fetch_assoc($query)){ ?>
        <div class="chapter">
            <div class="chapter-header" onclick="toggleChapter(this)">
                <span><?php echo htmlspecialchars($row['chapter_name']); ?></span>
                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="deleteAll.php?type=chapter&id=<?php echo $row['chapter_id']; ?>&subject=Dsa"
                       onclick="event.stopPropagation(); return confirm('Delete this chapter and all its topics?')"
                       style="color:#e74c3c; font-size:12px;">
                        <i class="fas fa-trash"></i>
                    </a>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            <ul class="chapter-content">
                <?php
                $chapter_id = $row['chapter_id'];
                $topics = mysqli_query($conn, "SELECT * FROM topics WHERE chapter_id=" . $chapter_id);
                while($topic = mysqli_fetch_assoc($topics)){
                ?>
                <li onclick="loadTopic(<?php echo $topic['topic_id']; ?>, this)">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span><?php echo htmlspecialchars($topic['topic_name']); ?></span>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <a href="addResource.php?topic_id=<?php echo $topic['topic_id']; ?>&subject=Dsa"
                               onclick="event.stopPropagation()"
                               style="color:#1f3f98; font-size:11px;">
                                <i class="fas fa-plus"></i>
                            </a>
                            <a href="deleteAll.php?type=topic&id=<?php echo $topic['topic_id']; ?>&subject=Dsa"
                               onclick="event.stopPropagation(); return confirm('Delete this topic?')"
                               style="color:#e74c3c; font-size:11px;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </li>
                <?php } ?>

                <li style="text-align:center; background:transparent; cursor:default;">
                    <a href="addTopic.php?chapter_id=<?php echo $row['chapter_id']; ?>&subject=Dsa"
                       onclick="event.stopPropagation()"
                       style="color:#1f3f98; font-size:12px; text-decoration:none;">
                        <i class="fas fa-plus"></i> Add Topic
                    </a>
                </li>
            </ul>
        </div>
        <?php } ?>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <div class="video-card" style="flex-direction:column; height:auto;">
            <div class="video-placeholder" id="videoPlaceholder">
                <i class="fas fa-play-circle"></i>
            </div>
            <iframe id="videoFrame" allowfullscreen style="width:100%; height:350px; border:none; display:none;"></iframe>

            <div id="videoNav" style="display:none; padding:10px; background:#f5f5f5; width:100%;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <button onclick="changeVideo(-1)" style="padding:6px 12px; background:#1f3f98; color:white; border:none; border-radius:4px; cursor:pointer;">
                        <i class="fas fa-chevron-left"></i> Prev
                    </button>
                    <span id="videoCounter" style="font-size:13px; color:#555;"></span>
                    <button onclick="changeVideo(1)" style="padding:6px 12px; background:#1f3f98; color:white; border:none; border-radius:4px; cursor:pointer;">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="notes-card">
            <div class="notes-header">
                <i class="fas fa-file-alt"></i> Notes
            </div>
            <div class="notes-content" id="notesBox"></div>
        </div>
    </main>

    <aside class="right-panel">
        <div class="tutorial-card" id="tutorialBox">
            <h3><i class="fas fa-book"></i> Tutorials</h3>
        </div>
    </aside>

</div>

<script>
    function toggleChapter(el) {
        el.parentElement.classList.toggle("active");
    }

    let currentVideos = [];
    let currentVideoIndex = 0;

    function loadTopic(topicId, liEl) {
        document.querySelectorAll('.chapter-content li').forEach(li => li.classList.remove('active-topic'));
        liEl.classList.add('active-topic');

        fetch('getResources.php?topic_id=' + topicId)
        .then(res => res.json())
        .then(data => {

            const iframe = document.getElementById('videoFrame');
            const placeholder = document.getElementById('videoPlaceholder');
            const videoNav = document.getElementById('videoNav');

            currentVideos = data.video;
            currentVideoIndex = 0;

            if (currentVideos.length > 0) {
                playVideo(0);
                videoNav.style.display = currentVideos.length > 1 ? 'block' : 'none';
                updateVideoCounter();
            } else {
                iframe.src = '';
                iframe.style.display = 'none';
                placeholder.style.display = 'flex';
                placeholder.innerHTML = '<i class="fas fa-play-circle"></i><p>No video available</p>';
                videoNav.style.display = 'none';
            }

            const notesBox = document.getElementById('notesBox');
            if (data.notes.length > 0) {
                notesBox.innerHTML = data.notes.map(n => `
                    <p><strong>${n.title || 'Notes'}</strong></p>
                    <a href="${n.link}" target="_blank">
                        <i class="fas fa-external-link-alt"></i> ${n.link}
                    </a><br><br>
                `).join('');
            } else {
                notesBox.innerHTML = '<span class="placeholder-text">No notes available.</span>';
            }

            const tutorialBox = document.getElementById('tutorialBox');
            if (data.tutorial.length > 0) {
                tutorialBox.innerHTML = `
                    <h3><i class="fas fa-book"></i> Tutorials</h3>
                    ${data.tutorial.map(t => `
                        <a href="${t.link}" target="_blank">
                            ${t.title || 'Open Tutorial'}
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    `).join('')}`;
            } else {
                tutorialBox.innerHTML = `
                    <h3><i class="fas fa-book"></i> Tutorials</h3>
                    <p class="placeholder-text" style="padding:14px;">No tutorial available.</p>`;
            }
        })
        .catch(err => console.error('Error:', err));
    }

    function playVideo(index) {
        const iframe = document.getElementById('videoFrame');
        const placeholder = document.getElementById('videoPlaceholder');
        currentVideoIndex = index;
        iframe.src = convertToEmbed(currentVideos[index].link);
        iframe.style.display = 'block';
        placeholder.style.display = 'none';
        updateVideoCounter();
    }

    function changeVideo(direction) {
        let newIndex = currentVideoIndex + direction;
        if (newIndex < 0) newIndex = currentVideos.length - 1;
        if (newIndex >= currentVideos.length) newIndex = 0;
        playVideo(newIndex);
    }

    function updateVideoCounter() {
        const counter = document.getElementById('videoCounter');
        if (counter) counter.textContent = `Video ${currentVideoIndex + 1} / ${currentVideos.length}`;
    }

    function convertToEmbed(url) {
        const match = url.match(/(?:youtu\.be\/|v=)([^&]+)/);
        return match ? 'https://www.youtube.com/embed/' + match[1] : url;
    }
</script>

</body>
</html>
