<h1>My Kylix application won't run outside the IDE</h1>
<div class="date">01.01.2007</div>


<p>Why is it when I try to run my Kylix App outside the IDE I get this message:</p>
<p>"error loading shared libraries: libqtintf.so: cannot open shared file: No such file or directory"?</p>
<p>This message and similar ones occur when ../kylix/bin is not included in your path when trying to use CLX components. Running /usr/kylix/bin/kylixpath is a short fix, but you can also add the line to your .bashrc file to set the paths whenever you start a shell. Be sure to change the appropriate .bashrc (ie. for user jbrown /home/jbrown/.bashrc).</p>
<p>Example .bashrc:</p>
<p>------------------------------</p>
<p>#.bashrc</p>
<p>..</p>
<p>source /usr/kylix/bin/kylixpath</p>
<p>..</p>
<p>------------------------------&nbsp;&nbsp;</p>

