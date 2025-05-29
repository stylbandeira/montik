import { useEffect, useState } from 'react';

export default function Cupom() {

    const handleChange = (e) => {
        console.log('aa')
        // e.preventDefault();
    }

    const handleCupom = async () => {

    }

    return (
        <>
            <div className="m-2 w-100">
                <form className='w-100'>
                    <input
                        type="text"
                        className='w-100'
                        placeholder='Digite o Cupom'
                    />

                    <button
                        onClick={handleCupom}
                        className='w-100 btn btn-success mt-2'
                    >
                        Aplicar Cupom
                    </button>
                </form>
            </div>
        </>
    );
}
