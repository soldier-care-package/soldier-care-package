import React from "react"
import {History} from "../components/History-request";
import Button from "react-bootstrap/Button";

export const SoldierHistory = () => {
	return (
		<>
			<div className="mb-2 p-4">
				<Button variant="secondary" size="lg">
					Posted
				</Button>{' '}
				<Button variant="primary" size="lg">
					Pending/History
				</Button>
			</div>
			<h1>Soldier Username Fulfilled Request History</h1>
			<History/>
		</>
	)
}