<h1>Kylix 3 encounters declaration syntax errors in TIME.H</h1>
<div class="date">01.01.2007</div>


<p>I am using Kylix 3, and get declaration syntax errors in TIME.H when attempting to compile any project. How can I solve this problem?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>The TIME.H declaration syntax errors can be resolved by going into the Project Options and moving the reference to /usr/include up in the Include path. Preferably, /usr/include should be moved to the very first position in the ordered Include path.</p>
<p>The exact cause of this problem is not yet known, but it could be related to Kylix 3 finding a different version of TIME.H elsewhere on the system. For reference, Kylix 3 contains four instances of TIME.H, in the following locations:</p>
<p>/usr/include/linux</p>
<p>/usr/include/bits</p>
<p>/usr/include/sys</p>
<p>/usr/include&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

