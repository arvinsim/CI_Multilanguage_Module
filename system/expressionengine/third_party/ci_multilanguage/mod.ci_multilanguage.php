<?php

	if (!defined('BASEPATH'))
	{
		exit('No direct script access allowed');
	}

	class Ci_multilanguage
	{
		private function _get_logged_in_preferred_user_language_id()
		{
			$logged_in = (ee()->session->userdata('member_id') == 0) ? FALSE : TRUE;
			if ($logged_in === TRUE)
			{
				$member_id = ee()->session->userdata('member_id');

				$sql = "
					SELECT
						`exp_members`.`language`
					FROM
						`exp_members`
					WHERE
						`exp_members`.`member_id` = '{$member_id}'
					LIMIT 1
				";

				$row_array = ee()->db->query($sql)->row_array();
				return $row_array['language'];
			}
			else
			{
				return FALSE;
			}
		}

		private function _get_preferred_user_language_id()
		{
			$logged_in_preferred_user_language_id = $this->_get_logged_in_preferred_user_language_id();
			if ($logged_in_preferred_user_language_id === FALSE)
			{
				$cookie_preferred_user_language_id = ee()->input->cookie('preferred_user_language');
				if ($cookie_preferred_user_language_id === FALSE)
				{
					return ee()->config->item('language');
				}
				else
				{
					return $cookie_preferred_user_language_id;
				}
			}
			else
			{
				return $logged_in_preferred_user_language_id;
			}
		}

		public function __construct()
		{
			// Load Admin Model
			ee()->load->model('admin_model');
		}

		public function action_switch_language()
		{
			$preferred_user_language = $_GET['preferred_user_language'];

			// Check if cookie is in the list of languages available
			$installed_languages = ee()->admin_model->get_installed_language_packs();

			$is_preferred_user_language_valid = FALSE;
			foreach ($installed_languages as $language_key => $language_value)
			{
				if ($language_key === $preferred_user_language)
				{
					$is_preferred_user_language_valid = TRUE;
					break;
				}
			}

			// Set Cookie if cookie preferred_user_language is valid
			if ($is_preferred_user_language_valid === TRUE)
			{
				// Set a cookie that expires in 1 day(3600 seconds * 24)
				ee()->functions->set_cookie('preferred_user_language', $preferred_user_language, 3600 * 24);

				$logged_in = (ee()->session->userdata('member_id') == 0) ? FALSE : TRUE;
				if ($logged_in === TRUE)
				{
					$member_id = ee()->session->userdata('member_id');

					$sql = "UPDATE `exp_members` SET `exp_members`.`language` = '{$preferred_user_language}' WHERE `exp_members`.`member_id` = '{$member_id}'";

					ee()->db->query($sql);
				}
			}

			$return_url = htmlentities($_GET['return_url']);
			ee()->functions->redirect($return_url);
		}

		// A getter of the user language id
		public function get_user_language_id()
		{
			return $this->_get_preferred_user_language_id();
		}

		public function switch_language_form()
		{
			// Set variables			
			$installed_languages = ee()->admin_model->get_installed_language_packs();

			$variables					 = array();
			$variable_row				 = array(
				'languages' => array()
			);
			$preferred_user_language_id	 = $this->_get_preferred_user_language_id();

			foreach ($installed_languages as $language_id => $language_name)
			{
				$data = array(
					'language_id'	 => $language_id,
					'language_name'	 => $language_name
				);

				if ($preferred_user_language_id === $language_id)
				{
					$data['selected'] = "selected='selected'";
				}
				else
				{
					$data['selected'] = "";
				}

				$variable_row['languages'][] = $data;
			}
			$variables[] = $variable_row;

			// Fetch contents of the tag pair, ie, the form contents
			$tagdata = ee()->TMPL->tagdata;

			// Parse Language variables
			$tagdata = ee()->TMPL->parse_variables($tagdata, $variables);

			// Get the template tag that will be parsed in the frontend to get the actual_action_id
			$template_tag_action_id = ee()->functions->fetch_action_id('Ci_multilanguage', 'action_switch_language');

			// Build an array to hold the form's hidden fields
			$hidden_fields = array(
				'return_url' => ee()->functions->fetch_current_uri(),
				'ACT'		 => $template_tag_action_id
			);

			// Build an array with the form data
			$form_data = array(
				'id'			 => ee()->TMPL->form_id,
				'class'			 => ee()->TMPL->form_class,
				'hidden_fields'	 => $hidden_fields
			);

			$form = ee()->functions->form_declaration($form_data) .
					$tagdata . "</form>";

			return $form;
		}

		public function switch_language_list()
		{
			// Set variables
			$installed_languages		 = ee()->admin_model->get_installed_language_packs();
			$preferred_user_language_id	 = $this->_get_preferred_user_language_id();

			// Get the actual action id as opposed to getting the template tag
			$action_id = ee()->functions->insert_action_ids(ee()->functions->fetch_action_id('Ci_multilanguage', 'action_switch_language'));

			$variables						 = array();
			$other_languages				 = array();
			$preferred_user_language_name	 = "";
			foreach ($installed_languages as $language_id => $language_name)
			{
				$href = http_build_query(array(
					'ACT'						 => $action_id,
					'return_url'				 => ee()->functions->fetch_current_uri(),
					'site_id'					 => '1',
					'preferred_user_language'	 => $language_id,
				));

				$data = array(
					'language_id'	 => $language_id,
					'language_name'	 => $language_name,
					'link_url'		 => ee()->functions->fetch_site_index() . '?' . $href
				);

				if ($preferred_user_language_id === $language_id)
				{
					$preferred_user_language_name = $language_name;
				}
				else
				{
					$other_languages[] = $data;
				}
			}
			$variables[] = array(
				'preferred_user_language_id'	 => $preferred_user_language_id,
				'preferred_user_language_name'	 => $preferred_user_language_name,
				'other_languages'				 => $other_languages
			);

			// Fetch contents of the tag pair, ie, the form contents
			$tagdata = ee()->TMPL->tagdata;

			// Parse Language variables
			$tagdata = ee()->TMPL->parse_variables($tagdata, $variables);

			return $tagdata;
		}
	}

	/* End of file mod.ci_multilanguage.php */
	/* Location: /system/expressionengine/third_party/ci_multilanguage/mod.ci_multilanguage.php */