class universibo
{
  exec {'composer install':
    user        => 'vagrant',
    environment => [
      'COMPOSER_HOME=/home/vagrant'
    ],
    cwd         => '/vagrant',
    command     => 'composer install -o --dev --no-interaction',
    timeout     => 1800,
    logoutput   => true
  }

  exec {'load-db':
    cwd     => '/vagrant/app/sql/pgsql',
    command => 'cat devdb.sql | sed \'s/OWNER TO .*/OWNER TO universibo;/\' | su - postgres -c \'psql universibo\'',
    unless  => 'test `/vagrant/vagrant/scripts/check.tables.php` -gt 0',
    require => Exec['composer install']
  }

  exec {'load-forum':
    cwd     => '/vagrant/vendor/universibo/forum-bundle/Universibo/Bundle/ForumBundle/Tests/Resources/sql/',
    command => 'cat structure-postgres.sql data-postgres.sql | sed \'s/OWNER TO .*/OWNER TO universibo;/\' | su - postgres -c \'psql universibo_forum3\'',
    unless  => 'test `/vagrant/vagrant/scripts/check.forumtables.php` -gt 0',
    require => Exec['composer install']
  }

  host {'www.universibo.dev':
    ip           => '127.0.0.1',
    host_aliases => 'universibo.dev',
  }
}
