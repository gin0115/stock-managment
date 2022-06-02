<?php

/**
 * Extracts all Class, Function and Constants values from a defined stub file.
 *
 * File taken from pxlrbt's PHP-Scoper toolset.
 *
 * @source https://github.com/pxlrbt/php-scoper-prefix-remover
 */

namespace pxlrbt\PhpScoper\PrefixRemover;

use PhpParser\ParserFactory;

class IdentifierExtractor {

	public function __construct( $statements = null ) {
		$this->stubFiles         = array();
		$this->extractStatements = $statements ?? array(
			'Stmt_Class',
			'Stmt_Interface',
			'Stmt_Trait',
			'Stmt_Function',
		);
	}

	public function addStub( $file ) {
		$this->stubFiles[] = $file;
		return $this;
	}

	public function extract() {
		$identifiers = array();
		foreach ( $this->stubFiles as $file ) {
			$content     = file_get_contents( $file );
			$ast         = $this->generateAst( $content );
			$identifiers = array_merge( $identifiers, $this->extractIdentifiersFromAst( $ast ) );
		}

		return $identifiers;
	}

	protected function generateAst( $code ) {
		$parser = ( new ParserFactory )->create( ParserFactory::PREFER_PHP7 );
		return $parser->parse( $code );
	}

	protected function extractIdentifiersFromAst( $ast ) {
		$globals = array();
		$items   = $ast;

		while ( count( $items ) > 0 ) {
			$item = array_pop( $items );

			if ( isset( $item->stmts ) ) {
				$items = array_merge( $items, $item->stmts );
			}

			if ( in_array( $item->getType(), $this->extractStatements ) ) {
				$globals[] = $item->name;
			}
		}

		return $globals;
	}
}
