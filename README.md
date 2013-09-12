CI Multilanguage Modile
=======================

ExpressionEngine module that supports Multilanguage features by leveraging underlying Codeigniter's language structure

# Requirements
ExpressionEngine 2.7+
	
# How to use

```{exp:ci_multilanguage:get_translation}```
-----------------------------------------------

Use this function to get a language variable

<pre>
{exp:ci_multilanguage:get_translation name="heading_company_name" file="application"}
</pre>

**Parameters**

<dl>
	<dt>name</dt>
	<dd>The key of the language variable</dd>

	<dt>args</dt>
	<dd>
	This is used to pass data for language variable strings that need to be "printf"'ed.
	An example would be a string like 

    <pre>This is a %s.</pre>

	or

    <pre>This %s is better than %s.</pre>

	To pass multiple values, pass a string using || as a separator

    <pre>Apples||Oranges||Lemons</pre>
	</dd>

	<dt>file</dt>
	<dd>
		The language file to find the language variable. Keep in mind that you don't need to pass the <code>_lang</code> suffix
		So if the file is named <code>application_lang.php</code> just pass <code>application</code>.
	</dd>
</dl>

```{exp:ci_multilanguage:get_user_language_id}```
---------------------------------------------------
Use this to get the id of the language that is currently being used

```{exp:ci_multilanguage:switch_language_form}```
---------------------------------------------------
Documentation coming soon

```{exp:ci_multilanguage:switch_language_list}```
---------------------------------------------------
Use this to get the list of languages available for the 

<pre>
{exp:ci_multilanguage:switch_language_list}
	{preferred_user_language_id}
	{preferred_user_language_name}
	{other_languages}
		{link_url}
		{language_id}
		{language_name}
	{/other_languages}
{/exp:ci_multilanguage:switch_language_list}
</pre>

**Variables**

<dl>
	<dt>preferred_user_language_name</dt>
	<dd>The id of the preferred user language</dd>

	<dt>preferred_user_language_name</dt>
	<dd>The name of the preferred user language</dd>

	<dt>other_languages</dt>
	<dd>
		A list of languages and their data that are not currently selected
		<dl>
			<dt>link_url</dt>
			<dd>the url to go to change the current language into this language</dd>

			<dt>language_id</dt>
			<dd>The id of the language</dd>

			<dt>language_name</dt>
			<dd>The name of the language</dd>
		</dl>
	</dd>
</dl>