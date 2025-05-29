import { useEffect, useState } from 'react';

export default function Frete() {

    const handleChange = (e) => {
        console.log('aa')
        // e.preventDefault();
    }

    return (
        <>
            <div className="m-2 flex">
                <div className="bg-orange-100 flex align-middle items-center p-2">
                    Calcule o Frete:
                </div>

                <div className="bg-orange-100 flex align-middle items-center p-2">
                    <form onchange={handleChange}>
                        <input type="text" />
                    </form>
                </div>
            </div>
        </>
    );
}
