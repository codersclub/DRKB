<h1>Работа с сессиями</h1>
<div class="date">01.01.2007</div>


<p>Each function listed below returns information about a session or performs a task that affects the session, such as starting a session or adding a password.</p>


<p>DbiAddPassword:</p>
<p>Adds a password to the current session.</p>

<p>DbiCheckRefresh:</p>
<p>Checks for remote updates to tables for all cursors in the current session, and refreshes the cursors</p>
<p>if changed.</p>

<p>DbiCloseSession:</p>
<p>Closes the session associated with the given session handle.</p>

<p>DbiDropPassword:</p>
<p>Removes a password from the current session.</p>

<p>DbiGetCallBack:</p>
<p>Returns a pointer to the function previously registered by the client for the given callback type.</p>

<p>DbiGetCurrSession:</p>
<p>Returns the handle associated with the current session.</p>

<p>DbiGetDateFormat:</p>
<p>Gets the date format for the current session.</p>

<p>DbiGetNumberFormat:</p>
<p>Gets the number format for the current session.</p>

<p>DbiGetSesInfo:</p>
<p>Retrieves the environment settings for the current session.</p>

<p>DbiGetTimeFormat:</p>
<p>Gets the time format for the current session.</p>

<p>DbiRegisterCallBack:</p>
<p>Registers a callback function for the client application.</p>

<p>DbiSetCurrSession:</p>
<p>Sets the current session of the client application to the session associated with hSes.</p>

<p>DbiSetDateFormat:</p>
<p>Sets the date format for the current session.</p>

<p>DbiSetNumberFormat:</p>
<p>Sets the number format for the current session.</p>

<p>DbiSetPrivateDir:</p>
<p>Sets the private directory for the current session.</p>

<p>DbiSetTimeFormat:</p>
<p>Sets the time format for the current session.</p>

<p>DbiStartSession:</p>
<p>Starts a new session for the client application.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
