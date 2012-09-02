<h1>Why can't I run my Kylix application outside of the IDE?</h1>
<div class="date">01.01.2007</div>


<p>What do I need to do to run a Kylix application outside of the IDE? </p>
<p>You need to have your LD_LIBRARY_PATH variable set to your bin directory. Your bin directory is located under your Kylix directory. You can set this by sourcing the kylixpath script. From an xterm window go to the Kylix bin directory and enter </p>
<p>source kylixpath</p>
<p>See the README file for more details. </p>

