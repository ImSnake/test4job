<section class="content-box">
    <div class="top-block">
        <div>
            <h4>TASK MANAGER</h4>
            <h5>Tasks-list of all executers</h5>
        </div>
        <div>
            <span id="add-task" class="btn-green">add task</span>
        </div>
    </div>


    <div id="tasks" class="task-table">

        <div class="table-row">
            <div class="table-column num heading">N</div>
            <div class="table-column content heading">task</div>
            <div class="table-column text heading">executor</div>
            <div class="table-column text heading">email</div>
            <div class="table-column text heading">status</div>
        </div>

        <?php foreach ($content as $item): ?>
            <div class="table-row">
                <div class="table-column num"><?= $item['id'] ?></div>
                <div class="table-column content"><?= $item['content'] ?></div>
                <div class="table-column text"><?= $item['executor'] ?></div>
                <div class="table-column text"><?= $item['email'] ?></div>
                <div class="table-column text"><?= $item['status'] ?></div>
            </div>
        <?php endforeach; ?>

    </div>

<!--    <a class="pagination" href="/site/pagination">SHOW MORE</a>-->
    <div class="nav">
        <a class="btn-grey previous" href="/site?step=b">previous</a>
        <a class="btn-grey next" href="/site?step=f">next</a>
    </div>
</section>

<div class="body-disable hide-element">

    <div class="content-box add-new-task">
        <div>
            <span class="btn-close">close</span>
        </div>

           <!-- <form name="form" method="post" action="<?/*= $_SERVER['REQUEST_URI'] */?>">-->
            <form name="form" method="post" action="/site?post">
                <div>
                    <label for="name">executor</label>
                    <input name="name" type="text" placeholder="enter name" required>
                </div>

                <div>
                    <label for="">email</label>
                    <input name="email" type="email" placeholder="enter email" required>
                </div>

                <div>
                    <label for="task">task</label>
                    <textarea name="task" placeholder="enter text" required></textarea>
                </div>

                <div>
                    <button name="submit_task" id="send-task" class="btn-green" type="submit">save</button>
                </div>
            </form>
        </div>

</div>
