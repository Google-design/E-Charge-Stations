<?php declare( strict_types=1 );

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg\Plugin;

use FernleafSystems\Wordpress\Services\Services;

class Data {

	private static ?array $data = null;

	public static function RetrieveFor( string $plugin ) :?array {
		if ( self::$data === null ) {
			$raw = Services::Data()->readFileWithInclude( Services::DataDir( 'plugins.json' ) );
			if ( empty( $raw ) ) {
				$raw = Services::WpFs()->getFileContent( $raw );
			}
			self::$data = empty( $raw ) ? [] : \json_decode( $raw, true );
		}
		return self::$data[ $plugin ] ?? null;
	}
}