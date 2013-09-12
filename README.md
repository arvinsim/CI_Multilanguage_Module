CI Multilanguage Modile
=======================

ExpressionEngine module that supports Multilanguage features by leveraging underlying Codeigniter's language structure

# Requirements
ExpressionEngine 2.7+
	
# How to use

```{exp:ci_multilanguage:get_translation}```
-----------------------------------------------

Use this function to get a language variable

```
	{exp:ci_multilanguage:get_translation name="heading_company_name" file="application"}
```

Parameters

<dl>
	<dt>name</dt>
	<dd>The key of the language variable</dd>

	<dt>args</dt>
	<dd>
	This is used to pass data for language variable strings that need to be "printf"'ed.
	An example would be a string like 

    This is a %s.</code>

	or

    <code>This %s is better than %s.</code>

	To pass multiple values, pass a string using || as a separator

    <code>Apples||Oranges||Lemons</code>
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


```{exp:ci_multilanguage:switch_language_list}```
---------------------------------------------------
