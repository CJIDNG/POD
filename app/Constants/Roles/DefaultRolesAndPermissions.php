<?php

namespace App\Constants\Roles;

class DefaultRolesAndPermissions
{
  public static function permissions() {
    return [
      /**
       * posts permissions
       */
      'create_posts',
      'update_posts',
      'update_own_posts',
      'view_posts',
      'view_own_posts',
      'delete_posts',
      'delete_own_posts',
      'approve_posts',
      'publish_posts',

      /**
       * datasets permissions
       */
      'create_datasets',
      'update_datasets',
      'update_own_datasets',
      'view_datasets',
      'view_own_datasets',
      'delete_datasets',
      'delete_own_datasets',
      'approve_datasets',
      'publish_datasets',

      /**
       * dataformats permissions
       */
      'create_dataformats',
      'update_dataformats',
      'view_dataformats',
      'delete_dataformats',

      /**
       * datalicenses permissions
       */
      'create_datalicenses',
      'update_datalicenses',
      'view_datalicenses',
      'delete_datalicenses',

      /**
       * datatopics permissions
       */
      'create_datatopics',
      'update_datatopics',
      'view_datatopics',
      'delete_datatopics',

      /**
       * roles permissions
       */
      'create_roles',
      'update_roles',
      'view_roles',
      'delete_roles',

      /**
       * users permissions
       */
      'view_users',
      'view_own_users',
      'create_users',
      'update_users',
      'update_own_users',
      'delete_users',
      'delete_own_users',
      'change_users_password',
      'change_users_own_password',

      /**
       * agency permissions
       */
      'create_agencies',
      'update_agencies',
      'view_agencies',
      'delete_agencies',

      /**
       * ministry permissions
       */
      'create_ministries',
      'update_ministries',
      'view_ministries',
      'delete_ministries',

      /**
       * localGovernment permissions
       */
      'create_localGovernments',
      'update_localGovernments',
      'view_localGovernments',
      'delete_localGovernments',

      /**
       * state permissions
       */
      'create_states',
      'update_states',
      'view_states',
      'delete_states',

      /**
       * health care facilities permissions
       */
      'create_health_facilities',
      'update_health_facilities',
      'view_health_facilities',
      'delete_health_facilities',

      /**
       * government_project permissions
       */
      'create_government_projects',
      'update_government_projects',
      'view_government_projects',
      'delete_government_projects',

      /**
       * statuses permissions
       */
      'create_statuses',
      'update_statuses',
      'view_statuses',
      'delete_statuses',

      /**
       * types permissions
       */
      'create_types',
      'update_types',
      'view_types',
      'delete_types',

      /**
       * incidents permissions
       */
      'create_incidents',
      'update_incidents',
      'view_incidents',
      'delete_incidents',

      /**
       * partners permissions
       */
      'create_partners',
      'update_partners',
      'view_partners',
      'delete_partners',

      /**
       * designations permissions
       */
      'create_designations',
      'update_designations',
      'view_designations',
      'delete_designations',

      /**
       * members permissions
       */
      'create_members',
      'update_members',
      'view_members',
      'delete_members',

      /**
       * services permissions
       */
      'create_services',
      'update_services',
      'view_services',
      'delete_services',
    ];
  }

  public static function roles() {
    return [
      'Admin',
      'User',
      'Writer',
      'Editor',
      'Data Curator',
      'Data Researcher & Editor'
    ];
  }

  public static function rolesWithPermissions() {
    return [
      'Admin' => self::permissions(),
      'User' => [
        /**
         * posts permissions
         */
        'view_posts',

        /**
         * users permissions
         */
        'view_own_users',
        'update_own_users',
        'change_users_own_password',

        /**
         * localGovernment permissions
         */
        'view_localGovernments',

        /**
         * agency permissions
         */
        'view_agencies',

        /**
         * ministry permissions
         */
        'view_ministries',

        /**
         * government_project permissions
         */
        'view_government_projects',

        /**
         * statuses permissions
         */
        'view_statuses',

        /**
         * types permissions
         */
        'view_types',

        /**
         * state permissions
         */
        'view_states',

        /**
         * incidents permissions
         */
        'create_incidents',
        'view_incidents',
        'delete_incidents',

        /**
         * datasets permissions
         */
        'view_datasets',

        /**
         * dataformats permissions
         */
        'view_dataformats',

        /**
         * datalicenses permissions
         */
        'view_datalicenses',

        /**
         * datatopics permissions
         */
        'view_datatopics',
      ],
      'Writer' => [
        /**
         * posts permissions
         */
        'create_posts',
        'update_own_posts',
        'view_posts',
        'view_own_posts',
        'delete_own_posts',
        'publish_posts',

        /**
         * users permissions
         */
        'view_own_users',
        'update_own_users',
        'change_users_own_password',

        /**
         * statuses permissions
         */
        'view_statuses',

        /**
         * types permissions
         */
        'view_types',

        /**
         * localGovernment permissions
         */
        'view_localGovernments',

         /**
         * agency permissions
         */
        'view_agencies',

        /**
         * ministry permissions
         */
        'view_ministries',

        /**
         * government_project permissions
         */
        'view_government_projects',

        /**
         * state permissions
         */
        'view_states',

        /**
         * incidents permissions
         */
        'create_incidents',
        'view_incidents',
        'delete_incidents',

        /**
         * datasets permissions
         */
        'view_datasets',

        /**
         * dataformats permissions
         */
        'create_dataformats',
        'update_dataformats',
        'view_dataformats',
        'delete_dataformats',

        /**
         * datalicenses permissions
         */
        'create_datalicenses',
        'update_datalicenses',
        'view_datalicenses',
        'delete_datalicenses',

        /**
         * datatopics permissions
         */
        'create_datatopics',
        'update_datatopics',
        'view_datatopics',
        'delete_datatopics',
      ],
      'Editor' => [
        /**
         * posts permissions
         */
        'create_posts',
        'update_posts',
        'update_own_posts',
        'view_posts',
        'view_own_posts',
        'delete_posts',
        'delete_own_posts',
        'approve_posts',
        'publish_posts',

        /**
         * users permissions
         */
        'view_own_users',
        'update_own_users',
        'change_users_own_password',

        /**
         * statuses permissions
         */
        'view_statuses',

        /**
         * types permissions
         */
        'view_types',

        /**
         * localGovernment permissions
         */
        'view_localGovernments',

         /**
         * agency permissions
         */
        'view_agencies',

        /**
         * ministry permissions
         */
        'view_ministries',

        /**
         * government_project permissions
         */
        'view_government_projects',

        /**
         * state permissions
         */
        'view_states',

        /**
         * incidents permissions
         */
        'create_incidents',
        'view_incidents',
        'delete_incidents',

        /**
         * datasets permissions
         */
        'view_datasets',

        /**
         * dataformats permissions
         */
        'view_dataformats',

        /**
         * datalicenses permissions
         */
        'view_datalicenses',

        /**
         * datatopics permissions
         */
        'view_datatopics',
      ],
      'Data Curator' => [
        /**
         * posts permissions
         */
        'view_posts',

        /**
         * users permissions
         */
        'view_own_users',
        'update_own_users',
        'change_users_own_password',

        /**
         * statuses permissions
         */
        'view_statuses',

        /**
         * types permissions
         */
        'view_types',

        /**
         * localGovernment permissions
         */
        'view_localGovernments',

         /**
         * agency permissions
         */
        'view_agencies',

        /**
         * ministry permissions
         */
        'view_ministries',

        /**
         * government_project permissions
         */
        'view_government_projects',

        /**
         * state permissions
         */
        'view_states',

        /**
         * incidents permissions
         */
        'create_incidents',
        'view_incidents',
        'delete_incidents',

        /**
         * datasets permissions
         */
        'create_datasets',
        'update_datasets',
        'update_own_datasets',
        'view_datasets',
        'view_own_datasets',
        'delete_datasets',
        'delete_own_datasets',

        /**
         * dataformats permissions
         */
        'create_dataformats',
        'update_dataformats',
        'view_dataformats',

        /**
         * datalicenses permissions
         */
        'create_datalicenses',
        'update_datalicenses',
        'view_datalicenses',

        /**
         * datatopics permissions
         */
        'create_datatopics',
        'update_datatopics',
        'view_datatopics',
      ],
      'Data Researcher & Editor' => [
        /**
         * posts permissions
         */
        'view_posts',

        /**
         * users permissions
         */
        'view_own_users',
        'update_own_users',
        'change_users_own_password',

        /**
         * statuses permissions
         */
        'view_statuses',

        /**
         * types permissions
         */
        'view_types',

        /**
         * localGovernment permissions
         */
        'view_localGovernments',

         /**
         * agency permissions
         */
        'view_agencies',

        /**
         * ministry permissions
         */
        'view_ministries',

        /**
         * government_project permissions
         */
        'view_government_projects',

        /**
         * state permissions
         */
        'view_states',

        /**
         * incidents permissions
         */
        'create_incidents',
        'view_incidents',
        'delete_incidents',

        /**
         * datasets permissions
         */
        'create_datasets',
        'update_datasets',
        'update_own_datasets',
        'view_datasets',
        'view_own_datasets',
        'delete_datasets',
        'delete_own_datasets',
        'approve_datasets',
        'publish_datasets',

        /**
         * dataformats permissions
         */
        'create_dataformats',
        'update_dataformats',
        'view_dataformats',

        /**
         * datalicenses permissions
         */
        'create_datalicenses',
        'update_datalicenses',
        'view_datalicenses',
        'delete_datalicenses',

        /**
         * datatopics permissions
         */
        'create_datatopics',
        'update_datatopics',
        'view_datatopics',
        'delete_datatopics',
      ]
    ];
  }
}
