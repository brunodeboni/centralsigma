<?php

/**
 * Esta função pega as duas queries dos cursos e retorna uma lista com os cursos
 * aí dá pra fazer a validação se o curso é atual ou futuro
 */

function mesclarCursos(array $cursos_atuais, array $cursos_futuros){
	function mesclar_esse_curso($procurar_nessa_array, $esse_curso){
		$found = false;
		foreach($procurar_nessa_array as &$pr){
			if($pr['id_curso'] == $esse_curso['id_curso']){
				$pr = $esse_curso;
				$found = true;
				break;
			}
		}
		if(!$found){
			$procurar_nessa_array[] = $esse_curso;
		}
		
		return $procurar_nessa_array;
	}
	
	
	foreach($cursos_atuais as $curso){
		$cursos_futuros = mesclar_esse_curso($cursos_futuros,$curso);
	}
	
	foreach($cursos_futuros as &$curso){
		if(!isset($curso['turma_acontecendo_agora'])) $curso['turma_acontecendo_agora'] = false;
	}
	
	return $cursos_futuros;
}
