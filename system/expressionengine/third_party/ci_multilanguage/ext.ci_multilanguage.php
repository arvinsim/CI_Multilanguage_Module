<?php

	if (!defined('BASEPATH'))
	{
		exit('No direct script access allowed');
	}

	class Ci_multilanguage_ext
	{
		public $name			 = 'CI Multilanguage';
		public $version			 = '0.2';
		public $description		 = 'Hooks to set language';
		public $settings_exist	 = 'n';
		public $docs_url		 = '';

		/**
		 * Constructor
		 *
		 * @param   mixed   Settings array or empty string if none exist.
		 */
		public function __construct($settings = '')
		{
			// Load Admin Model
			ee()->load->model('admin_model');
		}

		/**
		 * Activate Extension
		 *
		 * This function enters the extension into the exp_extensions table
		 *
		 * @see http://codeigniter.com/user_guide/database/index.html for
		 * more information on the db class.
		 *
		 * @return void
		 */
		public function activate_extension()
		{
			$data = array(
				'class'		 => __CLASS__,
				'method'	 => 'do_sessions_start',
				'hook'		 => 'sessions_start',
				'priority'	 => 10,
				'version'	 => $this->version,
				'enabled'	 => 'y'
			);
			ee()->db->insert('extensions', $data);
		}

		public function do_sessions_start($session_object)
		{
			$cookie_preferred_user_language = ee()->input->cookie('preferred_user_language');

			if ($cookie_preferred_user_language)
			{
				// Check if cookie is in the list of languages available
				$languages = ee()->admin_model->get_installed_language_packs();

				$is_preferred_user_language_valid = FALSE;
				foreach ($languages as $language_key => $language_value)
				{
					if ($language_key == $cookie_preferred_user_language)
					{
						$is_preferred_user_language_valid = TRUE;
						break;
					}
				}

				// Set Cookie if cookie preferred_user_language is valid
				if ($is_preferred_user_language_valid === TRUE)
				{
					$session_object->userdata['language'] = $cookie_preferred_user_language;
				}
			}

			return $session_object;
		}

		/**
		 * Disable Extension
		 *
		 * This method removes information from the exp_extensions table
		 *
		 * @return void
		 */
		public function disable_extension()
		{
			ee()->db->where('class', __CLASS__);
			ee()->db->delete('extensions');
		}

		/**
		 * Update Extension
		 *
		 * This function performs any necessary db updates when the extension
		 * page is visited
		 *
		 * @return  mixed   void on update / false if none
		 */
		public function update_extension($current = '')
		{
			if ($current == '' OR $current == $this->version)
			{
				return FALSE;
			}

			if ($current < '0.2')
			{
				// Update to version 0.2
			}

			ee()->db->where('class', __CLASS__);
			ee()->db->update('extensions', array(
				'version' => $this->version
			));
		}
	}

	/* End of file ext.ci_multilanguage.php */
	/* Location: /system/expressionengine/third_party/ci_multilanguage/ext.ci_multilanguage.php */ 