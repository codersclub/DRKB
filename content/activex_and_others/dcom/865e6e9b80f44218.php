<h1>Sending a file via DCOM</h1>
<div class="date">01.01.2007</div>


<p>I would like to send a file through DCOM however I can only send standard types.  How can I send bytes across to a client?</p>
<p>You need to use a variant array (VarArrayLock should be useful as well).</p>
